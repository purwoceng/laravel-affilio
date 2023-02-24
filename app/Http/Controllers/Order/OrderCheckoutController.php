<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class OrderCheckoutController extends Controller
{
    public function getOrder(Request $request)
    {
        $arrayOrderIds = $request->order_data;

        if (!empty($arrayOrderIds)) {
            if (count($arrayOrderIds) > 0) {
                foreach ($arrayOrderIds as $key) {
                   $orderId = $key['order_id'];
                   $order = Order::where('id', $orderId)->first();

                    if (!empty($order)) {
                        $resultOrderProducts = [];
                        $results = [];
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
                                'receiptLink' => 'https://baleoassetsdev.s3.ap-southeast-1.amazonaws.com/uploads/ozil/2023/resi-dropshipper/file1672889279425Registration+Form+for+Google+Cloud+Fundamental+Trainings+1+Day++Trainocate+Indonesia.pdf',
                                'marketplaceSource' => 'LAINNYA',
                                'products' => $resultOrderProducts,
                            ];

                            return response()->json([
                            200,
                            'status' =>'success',
                            'data' => $results,
                            ]);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Order data not found!',
                        ]);
                    }
                }
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
        $orderData = json_decode($request->order_data,true);

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
}
