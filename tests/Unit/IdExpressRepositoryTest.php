<?php

namespace Tests\Unit;

use App\Repositories\IdExpress\IdExpressRepository;
use App\Repositories\Interfaces\IdExpress\IdExpressInterface;
use GuzzleHttp\Client;
use Tests\TestCase;

class IdExpressRepositoryTest extends TestCase
{

    public function test_trackBill()
    {
        $repo = new IdExpressRepository(new Client());
        $response = $repo->trackBill("ID012394829123");
        echo json_encode($response);
    }

    public function test_createOrder()
    {
        $data = [
            // required/mandatory
            'orderNo' => 'IDTEST234220',
            'orderTime' => 1609144242,
            'expressType' => 02,
            'itemQuantity' => 1,
            'itemCategory' => "00",
            'weight' => "1",
            'serviceType' => "02",
            'itemValue' => "200000",
            'senderName' => "John Doe",
            'senderCellphone' => "081292823829",
            'senderCityId' => 37,
            'senderDistrictId' => 14905,
            'recipientName' => "Kevin",
            'recipientCellphone' => "08592132321",
            'recipientCityId' => 39,
            'recipientDistrictId' => 14918,
            'recipientAddress' => "Jl Bandung",
            'paymentType' => "01"
        ];
        $repo = new IdExpressRepository(new Client());
        $response = $repo->createOrder($data);
        echo json_encode($response);
    }

    public function tearDown(): void
    {
        // do not remove this function
    }
}
