<?php

namespace App\Lib\Expedition;

use GuzzleHttp\Client;
use phpDocumentor\Reflection\DocBlock\Tags\Param;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use stdClass;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class IdExpress
{
    protected $appId = null;
    protected $securityKey = null;
    protected $baseUrl = URL_API_IDE;
    private $db;
    private $original_response = null;
    private $logger = null;
    private $response = null;
    private $apiKey = null;
    private $apiKeyPickup = null;

    protected $supportedCouriers =  [
        'idexpress', 'ide'
    ];

    public function __construct()
    {
        $this->appId = APP_ID_IDE;
        $this->securityKey = SECURITY_KEY_IDE;

        $this->logger =  Log::build([
            'driver' => 'single',
            'path' => storage_path('logs/idexpress/' . date("Y_m_d") . '.log'),
        ]);

    }

    public function setDb($db)
    {
        $this->db = $db;
        return $this;
    }

    public function setApiKey($apiKey, $apiKeyPickup = '')
    {
        $this->apiKey = $apiKey;
        $this->apiKeyPickup = $apiKeyPickup;
        return $this;
    }

    public function getOrder($order_id)
    {
        return DB::table('orders')->first($order_id);
    }

    public function stringData($data)
    {
        $data = json_encode($data);
        return $data;
    }

    public function getSignature($data, $bulk = false)
    {
        if ($bulk) {
            $sign = md5(json_encode([$data]) . $this->appId . $this->securityKey);
        } else {
            $sign = md5(json_encode($data) . $this->appId . $this->securityKey);
        }
        return $sign;
    }

    public function getUrl($endpoint)
    {
        return $this->baseUrl . 'open/v1/waybill/' . $endpoint;
    }

    public function setRequest($data, $bulk = false)
    {
        if ($bulk) {
            $setdata = json_encode([$data]);
        } else {
            $setdata = json_encode($data);
        }
        return [
            'appId' => $this->appId,
            'sign' => $this->getSignature($data, $bulk),
            'data' => $setdata
        ];
    }

    public function getIdExpressDestination($data)
    {
        /**
         * Example :
         * [
         *      "province_id" = "1",
         *      "city_id" = "1",
         *      "district_id" = "1",
         * ]
         */
        $params = '';
        foreach ($data as $key => $value) {
            $params .= $key . "='$value' ";
        }
        $params = rtrim($params);

        $sql = "SELECT * FROM idexpress_destination WHERE $params";
        $result = DB::select($sql);
        return $result;
    }

    public function getMessage($code)
    {
        $message = [
            "0" => [
                "code" => "0",
                "desc" => "Success",
                "desc_id" => "Sukses",
            ],
            "100000" => [
                "code" => "100000",
                "desc" => "Partial data exception",
                "desc_id" => "Pengecualian data sebagian",
            ],
            "100001" => [
                "code" => "100001",
                "desc" => "The waybill has been picked up and cannot be updated",
                "desc_id" => "Waybill telah diambil dan tidak dapat diperbarui",
            ],
            "100002" => [
                "code" => "100002",
                "desc" => "Unable to find waybill",
                "desc_id" => "Tidak dapat menemukan waybill",
            ],
            "100003" => [
                "code" => "100003",
                "desc" => "No standard quote information found",
                "desc_id" => "Tidak ada informasi kutipan standar yang ditemukan",
            ],
            "100004" => [
                "code" => "100004",
                "desc" => "No shipment tracking found",
                "desc_id" => "Tidak ada pelacakan pengiriman yang ditemukan",
            ],
            "100005" => [
                "code" => "100005",
                "desc" => "Provinces and cities or regions are illegal",
                "desc_id" => "Provinsi dan kota atau wilayah ilegal",
            ],
            "100006" => [
                "code" => "100006",
                "desc" => "The waybill is not exist",
                "desc_id" => "waybill tidak ditemukan",
            ],
            "100007" => [
                "code" => "100007",
                "desc" => "The waybill is exist",
                "desc_id" => "waybill ditemukan",
            ],
            "100008" => [
                "code" => "100008",
                "desc" => "Shipping client doesn't exist",
                "desc_id" => "Klien pengiriman tidak ada",
            ],
            "100009" => [
                "code" => "100009",
                "desc" => "Shipping Client must be filled for COD Transaction",
                "desc_id" => "Pengiriman Client harus diisi untuk Transaksi COD",
            ],
            "100011" => [
                "code" => "100011",
                "desc" => "Pickup Start Time and Pickup End Time cannot be null",
                "desc_id" => "Waktu Mulai Penjemputan dan Waktu Berakhir Penjemputan tidak boleh nol",
            ],
            "100012" => [
                "code" => "100012",
                "desc" => "PickupEndTime must be at aleast 4 hours greater than pickupStartTime",
                "desc_id" => "PickupEndTime harus setidaknya 4 jam lebih lama dari pickupStartTime",
            ],
            "100013" => [
                "code" => "100013",
                "desc" => "PickupEndTime must be at aleast 4 hours greater than pickupStartTime",
                "desc_id" => "PickupStartTime harus setidaknya 1,5 jam lebih lama dari orderTime",
            ],
            "100014" => [
                "code" => "100014",
                "desc" => "Cash Payment is not available",
                "desc_id" => "Pembayaran Tunai tidak tersedia",
            ],
            "100015" => [
                "code" => "100015",
                "desc" => "WaybillNo and orderNo cannot be empty",
                "desc_id" => "WaybillNo dan orderNo tidak boleh kosong",
            ],
            "100016" => [
                "code" => "100016",
                "desc" => "The waybillNo is not equal to orderNo",
                "desc_id" => "waybillNo tidak sama dengan orderNo",
            ],
            "100017" => [
                "code" => "100017",
                "desc" => "pickupStartTime must use 10 digits unix timestamp",
                "desc_id" => "pickupStartTime must use 10 digits unix timestamp",
            ],
            "100018" => [
                "code" => "100018",
                "desc" => "pickupEndTime must use 10 digits unix timestamp",
                "desc_id" => "pickupEndTime must use 10 digits unix timestamp",
            ],
            "100019" => [
                "code" => "100019",
                "desc" => "Weight must be greater than 0",
                "desc_id" => "Berat harus lebih besar dari 0",
            ],
            "100020" => [
                "code" => "100020",
                "desc" => "Destination Province, City and District are not match",
                "desc_id" => "Provinsi Tujuan, Kota dan Kabupaten tidak cocok",
            ],
            "-100000" => [
                "code" => "-100000",
                "desc" => "System exception, please IDExpress Tech Dev",
                "desc_id" => "System exception, silakan hubungi IDExpress Tech Dev",
            ],
            "-100001" => [
                "code" => "-100001",
                "desc" => "Signature error",
                "desc_id" => "Signature error",
            ],
            "-100002" => [
                "code" => "-100002",
                "desc" => "Update failed",
                "desc_id" => "Pembaharuan gagal",
            ],
            "-100003" => [
                "code" => "-100003",
                "desc" => "Order is insured, itemValue cannot be empty",
                "desc_id" => "Pesanan diasuransikan, itemValue tidak boleh kosong",
            ],
            "-100004" => [
                "code" => "-100004",
                "desc" => "Illegal parameter",
                "desc_id" => "Illegal parameter",
            ],
        ];

        if ($message[$code]) {
            return $message[$code];
        }

        return [
            "code" => "",
            "desc" => "",
            "desc_id" => "",
        ];
    }

    public function generateWaybill($data, $bulk = false)
    {
        if (!$bulk) {
            $data = [$data];
        }
        $result = new stdClass();
        $result->data = $this->setRequest($data, $bulk);
        $result->url = $this->getUrl('create');
        $result->type = 'POST';
        return $this->request($result);
    }

    public function generateWaybillLp($noOrder, $pickupStartTime, $serviceType, $getDataOnly = false)
    {
        $dataOrder = $this->getLandingpageOrder($noOrder);

        if (count($dataOrder) > 0) {
            $noOrder = $dataOrder['id'];
            $codeOrder = isset($dataOrder['code']) ? $dataOrder['code'] : '';
            $dateCreated = date("Y-m-d H:i:s", strtotime($dataOrder['date_created']));
            $orderTime = strtotime($dateCreated);

            $dataOrderProduct = $this->getLandingpageOrderProduct($noOrder);

            $itemName = isset($dataOrderProduct['name']) ? $dataOrderProduct['name'] : '';
            $variationsProduct = isset($dataOrderProduct['options']) ? $dataOrderProduct['options'] : '';
            $itemRemarks = "";

            if ($variationsProduct != '[]' || $variationsProduct != '{}' || $variationsProduct != '') {
                $arr = json_decode($variationsProduct, true);
                $itemRemarks = isset($arr['name']) ? $arr['name'] : '';
            }

            $senderName = isset($dataOrder['dropshipper_name']) ? $dataOrder['dropshipper_name'] : '';
            $phone = isset($dataOrder['phone']) ? $dataOrder['phone'] : '0';
            $senderPhone = isset($dataOrder['dropshipper_phone']) ? $dataOrder['dropshipper_phone'] : '0';

            $senderProvinceId = $dataOrder['from_province_id'];
            $senderCityId = $this->getOrigin($dataOrder['from_city_id']);
            $senderDistrictId = $this->getDestination($dataOrder['from_subdistrict_id']);
            $senderProvinceId = $this->getProvinceIdByCityId($senderCityId);

            $senderAddress = $dataOrder['from_address'];
            $senderZipCode = isset($dataOrder['from_zip_code']) ? $dataOrder['from_zip_code'] : '00000';
            $recipientName = isset($dataOrder['name']) ? $dataOrder['name'] : '';

            $recipientDistrictId = $this->getDestination($dataOrder['subdistrict_id']);
            $dataRecipient = $this->getDestinationByIdeSubdistrictId($recipientDistrictId);
            $recipientCityId = $dataRecipient['city_id'];
            $recipientProvinceId = $dataRecipient['province_id'];

            $recipientAddress = isset($dataOrder['address']) ? $dataOrder['address'] : '';
            $expressType = isset($dataOrder['shipping_service']) ? $dataOrder['shipping_service'] : "STD";

            if (strpos(strtolower($serviceType), 'drop') !== false) {
                $serviceType = "01";
            } else {
                $serviceType = "00";
            }

            $expressType = isset($dataOrder['shipping_service']) ? $dataOrder['shipping_service'] : 'STD';

            switch (true) {
                case (strpos(strtolower($expressType), 'std') !== false):
                    $expressType = "00";
                    break;
                case (strpos(strtolower($expressType), 'smd') !== false):
                    $expressType = "01";
                    break;
                case (strpos(strtolower($expressType), 'truck') !== false):
                    $expressType = "06";
                    break;
                default:
                    $expressType = "00";
            }

            $itemQuantity = 0;
            $weight = 0;
            $value = 0;
            $codAmount = 0;
            $pickupStartTime = date("Y-m-d H:i:s", strtotime($pickupStartTime));
            $pickupStartTime = strtotime($pickupStartTime);
            // $pickupStartTime = strtotime('+2 hour', strtotime($pickupStartTime));

            $parcelData = [$this->generateParcelDataByOrderId($noOrder)];

            foreach ($parcelData as $key => $data) {
                $itemQuantity += (int)$data['parcel_qty'];
                $weight += $data['total_weight'];
                $value = $data['parcel_value'];
                $codAmount += (int)$data['cod_value'];
            }

            $pickupEndTime = strtotime('+1 days', $pickupStartTime);

            $data = [
                "orderNo" => $codeOrder,
                "orderTime" => $orderTime,
                "expressType" => $expressType,
                "itemName" => "$itemName",
                "insured" => "0",
                "itemRemarks" => ($itemRemarks == "") ? "" : "Variation=> " . $itemRemarks,
                "itemQuantity" => $itemQuantity,
                "itemCategory" => "00",
                "weight" => "$weight",
                "length" => 0,
                "width" => 0,
                "height" => 0,
                "itemValue" => "$value",
                "senderName" => "$senderName",
                "senderEmail" => "sender@gmail.com",
                "senderPhoneNumber" => "$senderPhone",
                "senderCellphone" => "$senderPhone",
                "senderProvinceId" => (int) $senderProvinceId,
                "senderCityId" => (int) $senderCityId,
                "senderDistrictId" => (int) $senderDistrictId,
                "senderAddress" => "$senderAddress",
                "senderZipCode" => "$senderZipCode",
                "recipientName" => "$recipientName",
                "recipientEmail" => "recipient@gmail.com",
                "recipientPhoneNumber" => "$phone",
                "recipientCellphone" => "$phone",
                "recipientProvinceId" => (int) $recipientProvinceId,
                "recipientCityId" => (int) $recipientCityId,
                "recipientDistrictId" => (int) $recipientDistrictId,
                "recipientAddress" => "$recipientAddress",
                "serviceType" => "$serviceType",
                "codAmount" => $codAmount,
                "paymentType" => "01",
                "pickupStartTime" => $pickupStartTime,
                "pickupEndTime" => $pickupEndTime
            ];

            if ($getDataOnly) {
                $senderProvinceName = $this->getProvinceName($dataOrder['from_province_id']);
                $senderCityName = $this->getCityName($dataOrder['from_city_id']);
                $senderDistrictName = $this->getSubdistrictName($dataOrder['from_subdistrict_id']);
                $data = array_merge($data, [
                    "senderProvinceName" => $senderProvinceName,
                    "senderCityName" => $senderCityName,
                    "senderDistrictName" => $senderDistrictName
                ]);
                return $data;
            }
            $result = $this->generateWaybill($data);

            if ($result['code'] == "200") {
                $result['results']['orderTime'] = date("Y-m-d H:i:s", $orderTime);
                $result['results']['pickupStartTime'] = date("Y-m-d H:i:s", $pickupStartTime);
                $result['results']['pickupEndTime'] = date("Y-m-d H:i:s", $pickupEndTime);
                return $result["results"];
            } else {
                return $result["results"];
            }
        } else {
            return "Order not found";
        }
    }

    public function mappingOrder($order, $params)
    {
        if ($params == 'create') {
            $data = [
                "orderNo" => "",
                "orderTime" => "",
                "expressType" => "",
                "itemName" => "",
                "insured" => "",
                "itemRemarks" => "",
                "itemQuantity" => "",
                "itemCategory" => "",
                "weight" => "",
                "length" => "",
                "width" => "",
                "height" => "",
                "itemValue" => "",
                "senderName" => "",
                "senderEmail" => "",
                "senderPhoneNumber" => "",
                "senderCellphone" => "",
                "senderProvinceId" => "",
                "senderCityId" => "",
                "senderDistrictId" => "",
                "senderAddress" => "",
                "senderZipCode" => "",
                "recipientName" => "",
                "recipientEmail" => "",
                "recipientPhoneNumber" => "",
                "recipientCellphone" => "",
                "recipientProvinceId" => "",
                "recipientCityId" => "",
                "recipientDistrictId" => "",
                "recipientAddress" => "",
                "serviceType" => "",
                "codAmount" => "",
                "paymentType" => "",
                "pickupStartTime" => "",
                "pickupEndTime" => ""
            ];
        }
    }

    public function generateTime($datetime)
    {
        $orderTime = strtotime($datetime);
        $pickupStartTime = strtotime($orderTime, strtotime('+2 hour'));
        $pickupEndTime = strtotime($orderTime, strtotime('+24 hour'));
        return compact('orderTime', 'pickupStartTime', 'pickupEndTime');
    }

    public function editWaybill($data)
    {
        /**
         * Edit Waybill Endpoint
         */
        $result = new stdClass();
        $result->data = $this->setRequest($data);
        $result->url = $this->getUrl('update');
        $result->type = 'POST';
        return $this->request($result);
    }

    public function cancelWaybill($waybill)
    {
        $dataRequest = [
            'waybillNo' => $waybill
        ];

        $result = new stdClass();
        $result->data = $this->setRequest($dataRequest);
        $result->url = $this->getUrl('cancel');
        $result->type = 'POST';

        $response = $this->request($result);
        if ($response['results']['code'] == "0") {
            return true;
        }

        return false;
    }

    public function getTracking($waybill)
    {
        $sign = md5($waybill . $this->appId . $this->securityKey);
        $data =  [
            'data' => $waybill,
            'appId' => $this->appId,
            'sign' => $sign
        ];
        $data = http_build_query($data);

        $url = $this->getUrl("get-tracking?" . $data);

        $client = new Client([
            'http_errors' => false,
            'base_uri' => $url
        ]);

        $response = $client->request("GET");
        $body = $response->getBody();
        $results = json_decode($body, true);
        $httpResponseCode = $response->getStatusCode();

        return [
            'body' => $body,
            'results' => $results,
            'code' => $httpResponseCode
        ];
    }

    public function checkStandardShippingFee($senderCityId, $recipientDistrictId, $weight, $expressType)
    {
        /**
         * Check Standar Shipping Fee
         * Params :
         * senderCityId - required
         * recipientDistrictId - required
         * weight - required - in Kilos
         * expressType : - 00 (Standar / STD) - 01 (Sameday / SMD) - 06 (iDtruck)
         * Example data :
         * [
         *      "senderCityId" => 36,
         *      "recipientDistrictId" => 548,
         *      "weight" => "200",
         *      "expressType" => "00"
         * ]
         */

        $senderCityId = $this->getOrigin($senderCityId);
        $recipientDistrictId = $this->getDestination($recipientDistrictId);
        $weight = (int) $weight;

        $dataRequest = [
            "senderCityId" => (int) $senderCityId,
            "recipientDistrictId" => (int) $recipientDistrictId,
            "weight" => number_format($weight / 1000, 2),
            "expressType" => $expressType
        ];

        $result = new stdClass();
        $result->data = $this->setRequest($dataRequest);
        $result->url = $this->getUrl('get-standard-fee');
        $result->type = 'POST';
        $response = $this->request($result);

        $results = $response['results'];
        $http_status_code = $response['code'];
        $body_status_code = $results['code'];
        $data = [
            'weight' => number_format($weight / 1000, 2),
            'origin_id' => (int) $senderCityId,
            'destination_id' => (int) $recipientDistrictId,
        ];

        if ($http_status_code == "200" && $body_status_code == "0") {
            return $this->toRajaOngkirFormatCost([$results], $data);
        } else {
            return $this->rajaOngkirEmptyResultCost();
        }
    }

    public function checkNearestBranch($data)
    {
        /**
         * Check Nearest Branch from Longitude & Latitude
         * Example :
         * [
         *      "longitude" => "",
         *      "latitude" => "",
         * ]
         */

        $result = new stdClass();
        $result->data = $this->setRequest($data);
        $result->url = $this->getUrl('get-nearest-branch');
        $result->type = 'POST';
        return $this->request($result);
    }

    public function shortingCodeCodAmount($data, $bulk = false)
    {
        /**
         * Example :
         * [
         *      'waybillNo' => 'xxxxx'
         * ]
         */

        if (!$bulk) {
            $data = [$data];
        }

        $result = new stdClass();
        $result->data = $this->setRequest($data, $bulk);
        $result->url = $this->getUrl('sorting-code-cod');
        $result->type = 'POST';
        return $this->request($result);
    }

    public function getWaybillLastStatus($waybill, $bulk = false)
    {
        /**
         * Example :
         * [
         *      "waybillNo" => ""
         * ]
         * OR
         * [
         *      [
         *          "waybillNo" => ""
         *      ],
         *      [
         *          "waybillNo" => ""
         *      ],
         * ]
         */

        $dataRequest = [
            "waybillNo" => $waybill
        ];

        if (!$bulk) {
            $dataRequest = [$dataRequest];
        }

        $responseWayBill = $this->getTracking($waybill);
        $results_waybill = $responseWayBill['results'];
        $code_response_from_ide_waybill = $results_waybill['code'];

        $result = new stdClass();
        $result->data = $this->setRequest($dataRequest, $bulk);
        $result->url = $this->getUrl('get-last-operation-waybill-with-fee');
        $result->type = 'POST';

        $response = $this->request($result);
        $http_status_code = $response['code'];
        $results = $response['results'];
        $code_response_from_ide = $results['code'];

        if ($code_response_from_ide_waybill == "200" &&  $code_response_from_ide == "200" && !empty($results['data']) && is_array($results['data'])) {
            return $this->toRajaOngkirFormatLastStatus($results['data'], $results_waybill, $http_status_code, $code_response_from_ide);
        } else {
            return $this->rajaOngkirEmptyResult();
        }
    }

    public function getWaybill($waybill, $bulk = false)
    {
        /**
         * Example :
         * [
         *      "waybillNo" => ""
         * ]
         * OR
         * [
         *      [
         *          "waybillNo" => ""
         *      ],
         *      [
         *          "waybillNo" => ""
         *      ],
         * ]
         */

        $dataRequest = [
            "waybillNo" => $waybill
        ];

        if (!$bulk) {
            $dataRequest = [$dataRequest];
        }

        $responseWayBill = $this->getTracking($waybill);
        $http_status_code = $responseWayBill['code'];
        $results_waybill = $responseWayBill['results'];
        $code_response_from_ide_waybill = $results_waybill['code'];

        if ($code_response_from_ide_waybill == "0" && !empty($results_waybill['data']) && is_array($results_waybill['data'])) {
            return $this->toRajaOngkirFormatTracking($results_waybill, $http_status_code, $code_response_from_ide_waybill);
        } else {
            return $this->rajaOngkirEmptyResult();
        }
    }

    public function request($request)
    {
        if ($request->type == "POST") {
            $client = new Client([
                'headers' => [
                    'content-type' => 'application/x-www-form-urlencoded'
                ],
                'form_params' => $request->data,
                'http_errors' => true,
                'base_uri' => $request->url
            ]);
        } else {
            $client = new Client([
                'headers' => [
                    'content-type' => 'application/x-www-form-urlencoded'
                ],
                'query' => $request->data,
                'http_errors' => false,
                'base_uri' => $request->url
            ]);
        }

        $this->response = $client->request($request->type);

        $body = $this->response->getBody();


        $results = json_decode($body, true);
        $this->original_response = $results;
        $httpResponseCode = $this->response->getStatusCode();
        return [
            'body' => $body,
            'results' => $results,
            'code' => $httpResponseCode
        ];
    }

    function strposa(string $haystack, array $needles, int $offset = 0): bool
    {
        foreach ($needles as $needle) {
            if (strpos($haystack, $needle, $offset) !== false) {
                return true;
            }
        }

        return false;
    }

    public function getStatusTracking($status)
    {
        $cancel_status = ['pickup failure'];
        $on_shipping_status = ['pick up scan', 'sending scan', 'arrival scan', 'delivery scan'];
        $received_status = ['pod scan'];
        $unknown_status = ['problem on shipment scan'];
        $rts_status = ['return confirm', 'return pod scan', 'confirm return bill'];

        $status = strtolower($status);

        if ($this->strposa($status, $cancel_status)) {
            return "cancel";
        } else if ($this->strposa($status, $on_shipping_status)) {
            return "shipping";
        } else if ($this->strposa($status, $received_status)) {
            return "received";
        } else  if ($this->strposa($status, $unknown_status)) {
            return "unknown";
        } else if ($this->strposa($status, $rts_status)) {
            return "rts";
        } else {
            return "untracked";
        }
    }

    public function toRajaOngkirFormatTracking(array $params, $httpResponCode, $httpResponStatus)
    {

        $data['rajaongkir']['query'] = [
            "waybill" => $params['data']['basicInfo']['waybillNo'],
            "courier" => "ide"
        ];

        $data['rajaongkir']['status'] = [
            "code" => $httpResponCode,
            "description" => $this->getMessage($httpResponStatus)['desc']
        ];

        $date = Date("Y-m-d h:i:s", (int) $params['data']['basicInfo']['orderTime'] / 1000);
        $pecahDate = explode(" ", $date);

        $waybillStatus = '';

        if (isset($params['data']['historys'])) {
            if (count($params['data']['historys']) > 0) {
                // $lastIndex = count($params['data']['historys']) - 1;
                $lastTrack = $params['data']['historys'][0];

                $waybillStatus = $this->getStatusTracking($lastTrack['operationType']);
            }
        }


        $data['rajaongkir']['result']['summary'] = [
            "courier_code" =>    "ide",
            "courier_name" =>    "ID EXPRESS",
            "waybill_number" =>  $params['data']['basicInfo']['waybillNo'],
            "service_code" =>    "",
            "waybill_date" =>    $pecahDate[0],
            "shipper_name" =>    $params['data']['senderInfo']['senderName'],
            "receiver_name" =>   $params['data']['recipientInfo']['recipientName'],
            "origin" =>          $params['data']['senderInfo']['senderCity'],
            "destination" =>     $params['data']['recipientInfo']['recipientDistrict'],
            "status" =>          $waybillStatus
        ];

        $manifested = [];
        $i = 1;

        if (isset($params['data']['historys'])) {
            foreach ($params['data']['historys'] as $result) {
                $date = Date("Y-m-d h:i:s", $result['operationTime']);
                $pecahDate = explode(" ", $date);

                $manifested[] = [
                    "manifest_code" =>       $i,
                    "manifest_description" => isset($result['problemDescription']) ? $result['problemDescription'] : $result['description'],
                    "manifest_date" =>        $pecahDate[0],
                    "manifest_time" =>        $pecahDate[1],
                    "city_name" =>            $result['currentBranch']
                ];

                $i++;
            }
        }

        $data['rajaongkir']['result']['manifest'] = array_reverse($manifested);

        return $data;
    }

    public function toRajaOngkirFormatLastStatus(array $params, array $paramsWaybill, $httpResponCode, $httpResponStatus)
    {

        $data['rajaongkir']['query'] = [
            "waybill" => $paramsWaybill['data']['basicInfo']['waybillNo'],
            "courier" => "ide"
        ];

        $data['rajaongkir']['status'] = [
            "code" => $httpResponCode,
            "description" => $this->getMessage($httpResponStatus)['desc']
        ];

        $date = Date("Y-m-d h:i:s", (int) $paramsWaybill['data']['basicInfo']['shipingTime'] / 1000);
        $pecahDate = explode(" ", $date);

        $data['rajaongkir']['result']['summary'] = [
            "courier_code" =>    "ide",
            "courier_name" =>    "IDExpress",
            "waybill_number" =>  $paramsWaybill['data']['basicInfo']['waybillNo'],
            "service_code" =>    "",
            "waybill_date" =>    $pecahDate[0],
            "shipper_name" =>    $paramsWaybill['data']['senderInfo']['senderName'],
            "receiver_name" =>   $paramsWaybill['data']['recipientInfo']['recipientName'],
            "origin" =>          $paramsWaybill['data']['recipientInfo']['SenderCity'],
            "destination" =>     $paramsWaybill['data']['recipientInfo']['recipientDistrict'],
            "status" =>          "on process"
        ];

        $manifested = [];
        $i = 1;

        foreach ($params as $result) {
            $date = Date("Y-m-d h:i:s", $result['lastOperationTime'] / 1000);
            $pecahDate = explode(" ", $date);

            $manifested[] = [
                "manifest_code" =>       $i,
                "manifest_description" => $result['description'],
                "manifest_date" =>        $pecahDate[0],
                "manifest_time" =>        $pecahDate[1],
                "city_name" =>            $result['lastOperationBranchName']
            ];

            $i++;
        }

        $data['rajaongkir']['result']['manifest'] = $manifested;

        return $data;
    }

    public function toRajaOngkirFormatCost(array $price_list, array $data)
    {
        $result = [];
        $costs = [];

        $result = [
            'rajaongkir' => [
                'query' => [
                    'courier' => 'ide',
                    'originType' => 'city',
                    'weight' => $data['weight'],
                    'origin' => $data['origin_id'],
                    'destination' => $data['destination_id'],
                    'destinationType' => 'subdistrict',
                ],
                'results' => [],
            ],
        ];

        if (!empty($price_list)) {
            foreach ($price_list as $cost) {
                // $etd = preg_replace('/\s+/', '', $cost['etd']);
                // $etd = str_replace("hari", "", $etd);
                $costs[] = [
                    'service' => "00",
                    'description' => $cost['desc'],
                    'cost' => [
                        [
                            'value' => (int)$cost['data'],
                            'etd' => "",
                            'note' => "",
                        ]
                    ],
                ];
            }
        }

        $result['rajaongkir']['results'][] = [
            'code' => 'ide',
            'name' => 'IDExpress',
            'costs' => $costs,
        ];

        return $result;
    }

    public function rajaOngkirEmptyResult()
    {
        $data['rajaongkir']['query'] = [];
        $data['rajaongkir']['status'] = [];
        $data['rajaongkir']['result']['summary'] = [];
        $data['rajaongkir']['result']['manifest'] = [];

        return $data;
    }

    public function rajaOngkirEmptyResultCost()
    {
        $data['rajaongkir']['query'] = [];
        $data['rajaongkir']['results'] = [];

        return $data;
    }

    public function getOrigin($city_id = 0)
    {
        $result = [];

        if ($city_id) {
            $sql = "
                SELECT idexpress_origin_map_api_city.origin_id
                FROM idexpress_origin_map_api_city
                LEFT JOIN idexpress_destination ON idexpress_origin_map_api_city.origin_id = idexpress_destination.city_id
                WHERE idexpress_origin_map_api_city.city_id = '$city_id'
                LIMIT 1
            ";
            $query = DB::select($sql);

            return $query['origin_id'] ?? '';
        }

        return $result;
    }

    public function getDestinationByIdeSubdistrictId($districtId) {
        $sql = "SELECT * FROM idexpress_destination WHERE district_id = '$districtId'";
        $query = DB::select($sql);
        return $query;
    }

    public function getDestination($subdistrict_id = 0)
    {
        $result = [];

        if ($subdistrict_id) {
            $sql = "
                SELECT idexpress_destination_map_api_subdistrict.destination_id
                FROM idexpress_destination_map_api_subdistrict
                LEFT JOIN idexpress_destination ON idexpress_destination_map_api_subdistrict.destination_id = idexpress_destination.district_id
                WHERE idexpress_destination_map_api_subdistrict.subdistrict_id = '$subdistrict_id' AND idexpress_destination.is_support_cod='1'
                LIMIT 1
            ";
            $query = DB::select($sql);

            return $query['destination_id'] ?? '';
        }

        return $result;
    }

    public function getLandingpageOrder($noOrder)
    {
        if (!$noOrder) {
            return [];
        }

        $sqlOrder = "SELECT * FROM landingpage_orders WHERE id = '$noOrder' AND (shipping_courier = 'idexpress' OR shipping_courier = 'ide')";
        $queryOrder = $this->db->query($sqlOrder);
        $dataOrder = $queryOrder->row;

        return $dataOrder;
    }

    public function getLandingpageOrderProduct($noOrder)
    {
        if (!$noOrder) {
            return [];
        }

        $sqlOrderProduct = "SELECT * FROM landingpage_order_product WHERE landingpage_order_id = '$noOrder'";
        $queryOrderProduct = $this->db->query($sqlOrderProduct);
        $dataOrderProduct = $queryOrderProduct->row;

        return $dataOrderProduct;
    }

    public function getProvinceIdByCityId($cityId)
    {
        if (!$cityId) {
            return '';
        }

        $sqlGetProvince = "SELECT province_id FROM idexpress_destination WHERE city_id = '$cityId' LIMIT 1";
        $queryGetProvince = $this->db->query($sqlGetProvince);
        $dataGetProvince = $queryGetProvince->row;

        return $dataGetProvince['province_id'] ?? '';
    }

    public function generateParcelDataByOrderId($orderId, array $overrideData = [])
    {
        $result = [
            "parcel_category" => 'Normal',
            "parcel_uom" => 'Pcs'
        ];

        $ordersProduct = $this->db->query("SELECT * FROM landingpage_order_product WHERE landingpage_order_id='$orderId'");
        $totalProfit = 0;

        if ($ordersProduct->num_rows > 0) {
            $parcelValue = 0;
            $parcelQty = 0;
            $weight = 0;

            foreach ($ordersProduct->rows as $key => $value) {
                $parcelValue += (int) $value['total'];
                $parcelQty += (int) $value['amount'];
                $weight += (int) ($value['total_weight']);
                $totalProfit += (int) $value['total_profit'];
            }

            $result['parcel_value'] = $parcelValue;
            $result['parcel_content'] = $ordersProduct->row['name'];
            $result['parcel_qty'] = $parcelQty;
            $result['total_weight'] = round($weight / 1000, 2);;
        }
        $order = $this->getLandingpageOrder($orderId);
        if ($order) {
            $codValue = (int)$order['shipping_cost'] + (int)$order['cod_fee'] + (int)$order['value'] + $totalProfit;
            $result['cod_value'] = (int)$codValue;
        }

        if (count($overrideData) > 0) {
            foreach ($overrideData as $key => $value) {
                if ($value != "") {
                    $result[$key] = $value;
                }
            }
        }
        return $result;
    }

    public function getProvinceName($provinceId)
    {
        $sql = "SELECT province AS province_name FROM api_province
            WHERE province_id = '{$provinceId}' LIMIT 1";
        $data = $this->db->query($sql)->row;
        $result = $data['province_name'] ?? '';
        if (trim(strtolower($result)) == 'nanggroe aceh darussalam') {
            return 'NAD';
        }
        return $result;
    }

    public function getCityName($cityId)
    {
        $sql = "SELECT city_name FROM api_city WHERE city_id = '{$cityId}' LIMIT 1";
        $data = $this->db->query($sql)->row;
        $result = $data['city_name'] ?? '';

        return $result;
    }

    public function getSubdistrictName($subdistrictId)
    {
        $sql = "SELECT subdistrict_name FROM api_subdistrict
            WHERE subdistrict_id = '{$subdistrictId}' LIMIT 1";
        $data = $this->db->query($sql)->row;
        $result = $data['subdistrict_name'] ?? '';

        return $result;
    }

    /**
     * @return null
     */
    public function getOriginalResponse()
    {
        return $this->original_response;
    }

    public function isDestinationSupportCod($apiSubdistrictId)
    {
        $sql = "SELECT is_support_cod FROM idexpress_destination id LEFT JOIN idexpress_destination_map_api_subdistrict idmas ON idmas.destination_id = id.district_id
            WHERE subdistrict_id = '{$apiSubdistrictId}' LIMIT 1";
        $data = $this->db->query($sql)->row;
        $result = $data['is_support_cod'] ?? '0';

        return $result == '1';
    }
}
