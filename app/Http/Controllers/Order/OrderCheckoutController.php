<?php

namespace App\Http\Controllers\Order;

use App\Models\Order;
use Illuminate\Support\Str;
use App\Models\OrderProduct;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
                        'variant_name' => $value->options,
                        'fee' => $value->fee,
                    ];
                }
                $order = [
                    'id' => $order->id,
                    'invoice_id' => $order->invoice_id,
                    'member_id' => $order->member_id,
                    'code' => $order->code,
                    'customer_name' => $order->customer_name,
                    'fee' => $order->fee,
                    'shipping_cost' => $order->shipping_cost,
                    'value' => $order->value,
                    'total' => $order->total,
                    'status' => $order->status,
                    'phone' => $order->phone,
                    'resi' => $order->resi,
                    'shipping_courier' => $order->shipping_courier,
                    'shipping_service' => $order->shipping_service,
                    'address' => $order->address,
                    'subdistrict_id' => $order->subdisctrict_id,
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
}
