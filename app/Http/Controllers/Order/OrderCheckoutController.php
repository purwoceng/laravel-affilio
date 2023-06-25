<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Fund;
use Carbon\Carbon;

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

                        $orderProducts = OrderProduct::where('order_id',$order->id)->get();
                            foreach ($orderProducts as $key => $orderProduct) {
                                $variant = json_decode($orderProduct->options,true);
                                $resultOrderProducts[] = [
                                    'productId' => $orderProduct->product_id,
                                    'quantity' => $orderProduct->amount,
                                    'variantId'=> $variant['desc_id'] ?? 0,
                                    'sellPrice'=> $orderProduct->selling_price ?? 0,
                                ];

                            }

                            $results[]= [
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
                                'receiptLink' => config('app.s3_url'). $order->pdf,
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
                'status' =>'success',
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

    public function updateOrder(Request $request)
    {
        $invoiceId = $request->invoice_id;
        $invoiceCode = $request->invoice_code;
        $invoiceTotal = $request->invoice_total;
        $orderData =  json_decode($request->order_data,true);

        if (empty($orderData)) {
            return response()->json([
                'status' => 'false',
                'title' => 'No Pesanan tidak ditemukan',
                'message' => 'Tidak ditemukan nomor pesanan tersebut',
                'icon' => 'error',
            ]);
        }
        for ($i=0; $i <count($orderData) ; $i++) {
            $orderId = $orderData[$i]['partnership_order_id'];
            $orderCode = $orderData[$i]['order_code'];
            $originOrderId = $orderData[$i]['order_id'];
            $status = 'paid';

            $updateData = [
                'baleo_invoice_id' => $invoiceId,
                'baleo_order_id' => $originOrderId,
                'baleo_invoice_code' => $invoiceCode,
                'baleo_order_code' => $orderCode,
                'baleomol_status' => $status,
                'date_checkout_baleo' => Carbon::now(),
            ];

            Order::where('id',$orderId)->update($updateData);
        }

        return response()->json([
            'status' => 'success',
            'title' => 'Pesanan Sukses Checkout',
            'message' => '<b>'. count($orderData) . '</b> Pesanan Anda telah berhasil checkout ke Baleomol.com. Kode Invoice anda: <b>#'. $invoiceCode .'</b>',
            'icon' => 'success',
        ]);
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
}
