<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fund;
use Carbon\Carbon;
use App\Lib\Affilio\Order as APIOrder;
use App\Lib\Affilio\Rbmq;

class OrderCheckoutController extends Controller
{
    public function getOrder(Request $request)
    {
        $arrayOrderIds = $request->order_data;

        if (!empty($arrayOrderIds)) {
            if (count($arrayOrderIds) > 0) {
                $results = [];
                foreach ($arrayOrderIds as $key) {
                    $orderId = $key['order_id'];
                    $order = Order::where('id', $orderId)->first();

                    if (!empty($order)) {
                        $resultOrderProducts = [];

                        $orderProducts = OrderProduct::where('order_id', $order->id)->get();
                        foreach ($orderProducts as $key => $orderProduct) {
                            $variant = json_decode($orderProduct->options, true);
                            $resultOrderProducts[] = [
                                'productId' => $orderProduct->product_id,
                                'quantity' => $orderProduct->amount,
                                'variantId' => $variant['desc_id'] ?? 0,
                                'sellPrice' => $orderProduct->selling_price ?? 0,
                            ];
                        }

                        $results[] = [
                            'partnershipOrderId' => $order->id,
                            'sellerUsername' => $order->seller,
                            'dropshipperName' => $order->dropshipper_name,
                            'dropshipperPhone' => $order->dropshipper_phone,
                            'receiverName' => $order->customer_name,
                            'receiverPhone' => $order->phone,
                            'receiverAddress' => $order->address,
                            'receiverSubdistrictId' => $order->subdistrict_id,
                            'receiverCityId' => $order->city_id,
                            'receiverProvinceId' => $order->province_id,
                            'receiverZipCode' => $order->zip_code,
                            'receiverNote' => $order->message ?? '-',
                            'receipt' => $order->resi ?? '',
                            'shippingCourier' => strtolower($order->shipping_courier),
                            'shippingService' => $order->shipping_service,
                            'receiptLink' => config('app.s3_url') . $order->pdf,
                            'marketplaceSource' => 'LAINNYA',
                            'products' => $resultOrderProducts,
                        ];
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Order data not found!',
                        ]);
                    }
                }

                return response()->json([
                    'status' => 'success',
                    'message' => 'Show all data order',
                    'data' => $results,
                ], 200);
            }
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Please fill `order_id` param!',
            ]);
        }
    }


    public function verification(Request $request)
    {
        if (!empty($request->id)) {

            // $data = [
            //     'status' => 'success',
            // ];
            Order::where('id', $request->id)->update(['status' => 'success']);
            // $data = [
            //     'is_active' => 1,
            // ];
            Fund::where('order_id', $request->id)->update(['is_active' => '1']);

            //push data ke rbmq
            $rbmq = new Rbmq();
            $dataOrder = Order::where('id', $request->id)->first();
            $baleoOrderId = $dataOrder->baleo_order_id;
            $baleoStatus = 'success';
            $rbmq->updateOrder($baleoOrderId, $baleoStatus);

            return response()->json([
                'status' => 'true',
                'title' => 'Berhasil Sukseskan Pesanan!',
                'message' => 'Berhasil melakukan sukseskan pesanan',
                'icon' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'title' => 'Gagal Suksesi !!',
                'message' => 'Gagal melakukan sukseskan pesanan',
                'icon' => 'warning',
            ]);
        }
    }

    public function batalkan(Request $request)
    {
        if (!empty($request->id)) {

            $apiOrder = new APIOrder();
            $rbmq = new Rbmq();

            // $data = [
            //     'status' => 'success',
            // ];
            $dataOrder = Order::where('id', $request->id)->first();
            $dataOrder->status = 'reject';
            $dataOrder->save();
            // $data = [
            //     'is_active' => 1,
            // ];
            Fund::where('order_id', $request->id)->update(['is_active' => '2']);

            //batalkan resi ke IDE
            $apiOrder->cancelWaybill($dataOrder->resi);

            //push data ke rbmq
            $baleoOrderId = $dataOrder->baleo_order_id;
            $baleoStatus = 'canceled';
            $rbmq->updateOrder($baleoOrderId, $baleoStatus);

            return response()->json([
                'status' => 'true',
                'title' => 'Berhasil Batalkan Pesanan!',
                'message' => 'Berhasil melakukan batalkan pesanan',
                'icon' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'title' => 'Gagal Pembatalan !!',
                'message' => 'Gagal melakukan pembatalan pesanan',
                'icon' => 'warning',
            ]);
        }
    }

    public function updateOrder(Request $request)
    {
        $invoiceId = $request->invoice_id;
        $invoiceCode = $request->invoice_code;
        $invoiceTotal = $request->invoice_total;
        $orderData =  json_decode($request->order_data, true);

        if (empty($orderData)) {
            return response()->json([
                'status' => 'false',
                'title' => 'No Pesanan tidak ditemukan',
                'message' => 'Tidak ditemukan nomor pesanan tersebut',
                'icon' => 'error',
            ]);
        }
        foreach ($orderData as $result) {
            $orderId = $result['partnership_order_id'];
            $orderCode = $result['order_code'];
            $originOrderId = $result['order_id'];
            $status = 'paid';
            $mesaggeArray = [];
            foreach ($result['products'] as $product){
                $mesaggeArray = array_merge($mesaggeArray, $product['errors']);
            }

            if(!empty($result['errors']) && is_array($result['errors'])){
                $mesaggeArray = array_merge($mesaggeArray, $result['errors']);
            }

            if(count($mesaggeArray) < 1){
                $updateData = [
                    'baleo_invoice_id' => $invoiceId,
                    'baleo_order_id' => $originOrderId,
                    'baleo_invoice_code' => $invoiceCode,
                    'baleo_order_code' => $orderCode,
                    'baleomol_status' => $status,
                    'date_checkout_baleo' => Carbon::now(),
                ];

                Order::where('id', $orderId)->update($updateData);
            }
        }



        return response()->json([
            'status' => 'success',
            'title' => 'Pesanan Sukses Checkout',
            'message' => '<b>' . count($orderData) . '</b> Pesanan Anda telah berhasil checkout ke Baleomol.com. Kode Invoice anda: <b>#' . $invoiceCode . '</b>',
            'icon' => 'success',
        ]);
    }

    public function reorderbaleo(Request $request)
    {
        if (!empty($request->id)) {
            Order::where('id', $request->id)->update(['baleomol_status' => 'unpaid']);
            return response()->json([
                'status' => 'true',
                'title' => 'Berhasil Mengubah Baleomol Status Ke Unpaid!',
                'message' => 'Berhasil melakukan reOrder pesanan',
                'icon' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'title' => 'Gagal ReOrder !!',
                'message' => 'Gagal melakukan Re order pesanan',
                'icon' => 'warning',
            ]);
        }
    }
}
