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
        $this->CREATE_URL = config('app.ide_url') . '/open/v1/waybill/create';
        $this->TRACK_URL = config('app.ide_url') . '/open/v1/waybill/get-tracking';
        $this->client = $client;
        $this->appId = config('app.ide_app_id');
        $this->securityKey = config('app.ide_security_key');
    }

    function trackBill(string $data)
    {
        $sign = $this->generateSign($data);
        $response = $this->client->GET($this->TRACK_URL.`/data=$data&appId=$this->appId&sign=$sign`);

        if ($response->getStatusCode() >= 400) {
            throw new HttpClientException(`API error code $response->getStatusCode() on trackBill() Id Express Repository : ` . $response->getBody()->getContents());
        }

        return $response->getBody();
    }

    function createOrder($data)
    {
        $payload = [
            // required/mandatory
            'orderNo' => $data['orderNo'],
            'orderTime' => $data['orderTime'],
            'expressType' => $data['expressType'],
            'itemQuantity' => $data['itemQuantity'],
            'itemCategory' => $data['itemCategory'],
            'weight' => $data['weight'],
            'serviceType' => $data['serviceType'],
            'itemValue' => $data['itemValue'],
            'senderName' => $data['senderName'],
            'senderCellphone' => $data['senderCellphone'],
            'senderCityId' => $data['senderCityId'],
            'senderDistrictId' => $data['senderDistrictId'],
            'recipientName' => $data['recipientName'],
            'recipientCellphone' => $data['recipientCellphone'],
            'recipientCityId' => $data['recipientCityId'],
            'recipientDistrictId' => $data['recipientDistrictId'],
            'recipientAddress' => $data['recipientAddress'],
            'paymentType' => $data['paymentType'],

            // nullable
            'waybillNo' => $data['waybillNo'] ?? null,
            'insured' => $data['insured'] ?? null,
            'itemRemarks' => $data['itemRemarks'] ?? null,
            'length' => $data['length'] ?? null,
            'width' => $data['width'] ?? null,
            'height' => $data['height'] ?? null,
            'senderEmail' => $data['senderEmail'] ?? null,
            'senderPhoneNumber' => $data['senderPhoneNumber'] ?? null,
            'senderProvinceId' => $data['senderProvinceId'] ?? null,
            'senderZipCode' => $data['senderZipCode'] ?? null,
            'recipientEmail' => $data['recipientEmail'] ?? null,
            'recipientPhoneNumber' => $data['recipientPhoneNumber'] ?? null,
            'recipientProvinceId' => $data['recipientProvinceId'] ?? null,
            'recipientZipCode' => $data['recipientZipCode'] ?? null,
            'codAmount' => $data['codAmount'] ?? null,
            'shippingclient' => $data['shippingclient'] ?? null,
        ];

        // Check if any of the required keys are missing
        $requiredKeys = [
            'orderNo', 'orderTime', 'expressType', 'itemQuantity', 'itemCategory',
            'weight', 'serviceType', 'itemValue', 'senderName', 'senderCellphone', 'senderCityId',
            'senderDistrictId', 'recipientName', 'recipientCellphone', 'recipientCityId',
            'recipientDistrictId', 'recipientAddress', 'paymentType'
        ];

        // If ServiceType = 00 (Pickup), then pickupStartTime and pickupEndTime parameters are mandatory.
        if ($data['serviceType'] === 00) {
            $requiredKeys[] = 'pickupStartTime';
            $requiredKeys[] = 'pickupEndTime';
        }


        $missingKeys = array_diff($requiredKeys, array_keys($payload));
        if (!empty($missingKeys)) {
            throw new InvalidArgumentException('Missing required on data: ' . implode(', ', $missingKeys));
        }

        $sign = $this->generateSign($payload);

        $response = $this->client->post($this->CREATE_URL, [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            'sign' => $sign,
            'data' => json_encode($payload),
            'appId' => $this->appId
        ]);

        if ($response->getStatusCode() >= 400) {
            throw new HttpClientException(`API error code $response->getStatusCode() on createOrder() Id Express Repository : ` . $response->getBody()->getContents());
        }

        return $response->getBody();
    }

    private function generateSign($data): string
    {
        return md5(json_encode($data) . $this->appId . $this->securityKey);
    }
}
