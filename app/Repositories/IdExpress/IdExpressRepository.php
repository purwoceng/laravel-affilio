<?php

namespace App\Repositories\IdExpress;

use App\Repositories\Interfaces\IdExpress\IdExpressInterface;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Client\HttpClientException;
use Illuminate\Support\Facades\Log;
use InvalidArgumentException;

class IdExpressRepository implements IdExpressInterface
{

    private string $appId;
    private string $securityKey;

    protected Client $client;

    private $CREATE_URL;
    private $TRACK_URL;

    // Inject Guzzle HTTP Client
    public function __construct(Client $client)
    {
        if (!config('app.ide_app_id') && !config('app.ide_security_key')) {
            Log::error('Error ! AppID : ' + config('app.ide_app_id') + 'Security Key : ' + config('app.ide_security_key'));
            throw new Exception(`Environment of ID Express is not completed`);
        }
        $this->CREATE_URL = config('app.ide_url') . 'open/v1/waybill/create';
        $this->TRACK_URL = config('app.ide_url') . 'open/v1/waybill/get-tracking';
        $this->client = $client;
        $this->appId = config('app.ide_app_id');
        $this->securityKey = config('app.ide_security_key');
    }

    function trackBill(string $data)
    {
        $sign = $this->generateSign($data);
        $url = $this->TRACK_URL . '?data=' . $data . '&appId=' . $this->appId . '&sign=' . $sign;
        $response = $this->client->GET($url);

        if ($response->getStatusCode() >= 400) {
            throw new HttpClientException(`API error code $response->getStatusCode() on trackBill() Id Express Repository : ` . $response->getBody()->getContents());
        }

        return json_decode($response->getBody()->getContents());
    }

    /**
     * @param $data array
     */
    function createOrder($data)
    {
        $payload = [];
        
        // Check if any of the required keys are missing
        $requiredKeys = [
            'orderNo', 'orderTime', 'expressType', 'itemQuantity', 'itemCategory',
            'weight', 'serviceType', 'itemValue', 'senderName', 'senderCellphone', 'senderCityId',
            'senderDistrictId', 'recipientName', 'recipientCellphone', 'recipientCityId',
            'recipientDistrictId', 'recipientAddress', 'paymentType', 'itemName'
        ];

        foreach ($data as $value) {
            $missingKeys = array_diff($requiredKeys, array_keys($value));
            if (!empty($missingKeys)) {
                throw new InvalidArgumentException('Missing required on data: ' . implode(', ', $missingKeys));
            }

            $payload[] = [
                // required/mandatory
                'orderNo' => $value['orderNo'],
                'orderTime' => $value['orderTime'],
                'expressType' => $value['expressType'],
                'itemQuantity' => $value['itemQuantity'],
                'itemCategory' => $value['itemCategory'],
                'weight' => $value['weight'],
                'serviceType' => $value['serviceType'],
                'itemValue' => $value['itemValue'],
                'senderName' => $value['senderName'],
                'senderCellphone' => $value['senderCellphone'],
                'senderCityId' => $value['senderCityId'],
                'senderDistrictId' => $value['senderDistrictId'],
                'recipientName' => $value['recipientName'],
                'recipientCellphone' => $value['recipientCellphone'],
                'recipientCityId' => $value['recipientCityId'],
                'recipientDistrictId' => $value['recipientDistrictId'],
                'recipientAddress' => $value['recipientAddress'],
                'paymentType' => $value['paymentType'],
                'itemName' => $value['itemName'],
    
                // nullable
                'waybillNo' => $value['waybillNo'] ?? null,
                'insured' => $value['insured'] ?? null,
                'itemRemarks' => $value['itemRemarks'] ?? null,
                'length' => $value['length'] ?? null,
                'width' => $value['width'] ?? null,
                'height' => $value['height'] ?? null,
                'senderEmail' => $value['senderEmail'] ?? null,
                'senderPhoneNumber' => $value['senderPhoneNumber'] ?? null,
                'senderProvinceId' => $value['senderProvinceId'] ?? null,
                'senderZipCode' => $value['senderZipCode'] ?? null,
                'recipientEmail' => $value['recipientEmail'] ?? null,
                'recipientPhoneNumber' => $value['recipientPhoneNumber'] ?? null,
                'recipientProvinceId' => $value['recipientProvinceId'] ?? null,
                'recipientZipCode' => $value['recipientZipCode'] ?? null,
                'codAmount' => $value['codAmount'] ?? null,
                'shippingclient' => $value['shippingclient'] ?? null,
            ];
        }

        $sign = $this->generateSign(json_encode($payload));

        $response = $this->client->post($this->CREATE_URL, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'form_params' => [
                'data' => json_encode($payload),
                'sign' => $sign,
                'appId' => $this->appId
            ]
        ]);

        if ($response->getStatusCode() >= 400) {
            throw new HttpClientException(`API error code $response->getStatusCode() on createOrder() Id Express Repository : ` . $response->getBody()->getContents());
        }

        return json_decode($response->getBody()->getContents());
    }

    private function generateSign($data): string
    {
        return md5($data. $this->appId . $this->securityKey);
    }
}
