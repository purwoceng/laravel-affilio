<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;


class WebHookBaleo extends Controller
{
    protected $token;
    protected $endpoint;
    protected $headers;

    public function __construct()
    {
        $this->token = config('app.baleomol_token_auth');
        $this->endpoint = config('app.baleomol_url') . '/whaffilio';
        $this->headers = [
            'Authorization' => "Bearer {$this->token}",
            'Content-Type' => "application/json"
        ];
    }

    public function syncOrder( Request $request)
    {
        $orders = $request->getContent();
        $dataOrders = json_decode($orders, true);

        if (empty($dataOrders)) {
            return response()->json([
                'status' => 'false',
                'title' => 'No Pesanan tidak ditemukan',
                'message' => 'Tidak ditemukan nomor pesanan tersebut',
                'icon' => 'error',
                'data' => $dataOrders
            ]);
        }


        $responseData = [];
        foreach ($dataOrders as $result){
            $order = Order::where('id', $result['orderId'])->first();
            $postData = $this->postOrderToBaleo($order);
            $responseData[]= $postData;
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Show all status sync',
            'data' => $responseData,
        ], 200);

    }

    private function postOrderToBaleo( Order $order)
    {
        try {
            Http::withHeaders($this->headers)->post($this->endpoint, [
            'orderId'=> $order->baleo_order_id,
            'receipt'=> $order->resi
            ]);

            $order->date_last_synced = Carbon::now();

            $order->save();

            return [
                'orderId'=> $order->id,
                'baleoOrderId' => $order->baleo_order_id,
                'status'=> 'success'
            ];
        } catch (\Exception $error){
            dd($error->getMessage());
            exit;
        }

    }

}
