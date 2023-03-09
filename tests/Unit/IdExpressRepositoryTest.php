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
        // orderNo that has been created in ID Express Staging
        $orderNo = "IDTEST234220zxczxc";

        $repo = new IdExpressRepository(new Client());
        $response = $repo->trackBill($orderNo);

        echo json_encode($response);
        $this->assertEquals(0, $response->code);
        $this->assertEquals($orderNo, $response->data->basicInfo->orderNo);
        
    }

    public function test_createOrder()
    {
        $orderNo = 'IDTEST'. rand();
        $data = [
            [
                'orderNo' => $orderNo,
                'orderTime' => 1609144242,
                'expressType' => "06",
                'itemQuantity' => 1,
                'itemCategory' => "00",
                'weight' => "1",
                'serviceType' => "01",
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
                'paymentType' => "01",
                'itemName' => "Barang A"
            ],
            [
                'orderNo' => $orderNo."123",
                'orderTime' => 1609144242,
                'expressType' => "06",
                'itemQuantity' => 1,
                'itemCategory' => "00",
                'weight' => "1",
                'serviceType' => "01",
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
                'paymentType' => "01",
                'itemName' => "Barang A"
            ]
        ];
        $repo = new IdExpressRepository(new Client());
        $response = $repo->createOrder($data);

        echo json_encode($response);
        $this->assertEquals(0, $response->code);
        $this->assertEquals($orderNo, $response->data[0]->orderNo);
        $this->assertEquals($orderNo."123", $response->data[1]->orderNo);
    }

    public function tearDown(): void
    {
        // do not remove this function
    }
}
