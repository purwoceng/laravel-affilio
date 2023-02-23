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
        if ($request->order_id) {
            $order = Order::where('id', $request->order_id)->first();
            if ($order->id) {
                $orderProducts = OrderProduct::where('order_id', $request->order_id)->get();
                foreach ($orderProducts as $key => $value) {
                    $resultOrderProducts[] = [
                        'order_id' => $value->order_id,
                        'product_id' => $value->product_id,
                        'product_name' => $value->product_name,
                        'original_price' => $value->original_price,
                        'price' => $value->price,
                        'weight' => $value->weight,
                        'amount' => $value->amount,
                        'total_origin_price' => $value->total_origin_price,
                        'total' => $value->total,
                        'markup_price' => $value->markup_price,
                        'selling_price' => $value->selling_price,
                        'total' => $value->total,
                        'total_original_price' => $value->total_original_price,
                        'total_profit' => $value->total_profit,
                        'total_profit_affiliator' => $value->total_profit_affiliator,
                        'total_profit_baleomol' => $value->total_profit_baleomol,
                        'total_weight' => $value->total_weight,
                        'options' => $value->options,
                        'fee' => $value->fee,
                    ];
                }
                $order = [
                    'id' => $order->id,
                    'invoice_id' => $order->invoice_id,
                    'member_id' => $order->member_id,
                    'seller' => $order->seller,
                    'dropshipper_name' => $order->dropshipper_name,
                    'dropshipper_phone' => $order->dropshipper_phone,
                    'code' => $order->code,
                    'customer_name' => $order->customer_name,
                    'fee' => $order->fee,
                    'shipping_cost' => $order->shipping_cost,
                    'value' => $order->value,
                    'total' => $order->total,
                    'status' => $order->status,
                    'phone' => $order->phone,
                    'resi' => $order->resi,
                    'shipping_courier' => strtolower($order->shipping_courier),
                    'shipping_service' => $order->shipping_service,
                    'address' => $order->address,
                    'subdistrict_id' => $order->subdistrict_id,
                    'city_id' => $order->city_id,
                    'province_id' => $order->province_id,
                    'subdistrict' => $order->subdistrict,
                    'city' =>$order->city,
                    'province' =>  $order->province,
                    'country' => $order->country,
                    'message' => empty($order->message) ? $order->message : 'Tidak Ada Catatan',
                    'zip_code' => $order->zip_code ?? '-',
                    'date_created' =>  date('Y-m-d H:i', strtotime($order->date_created)),
                ];

                return response()->json([
                    200,
                    'status' =>'success',
                    'data' => [
                        'order' => $order,
                        'orderProducts' => $resultOrderProducts,
                    ],
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Order data not found!',
                ]);
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
