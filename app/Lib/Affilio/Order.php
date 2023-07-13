<?php

namespace App\Lib\Affilio;

use Illuminate\Support\Facades\Http;

class Order
{

    private $url = 'https://api.aplikasix.dev';
    protected $headers;

    public function __construct()
    {
        if(config('env') === 'production'){
            $this->url = 'https://api.affilio.co.id';
        }

        $this->headers = [
            'Content-Type' => "application/json"
        ];
    }

    public function cancelWaybill( string $waybillId)
    {
        try {
            $endpoint = $this->url. '/orders/cancel-waybill/'.$waybillId;
            $response = Http::withHeaders($this->headers)->post($endpoint);
            $result = $response->body();
            return json_decode($result, true);
        } catch (\Exception $error){

        }

    }
}
