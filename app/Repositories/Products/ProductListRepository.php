<?php

namespace App\Repositories\Products;

use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\Products\ProductListRepositoryInterface;

class ProductListRepository implements ProductListRepositoryInterface
{
    private $totalProduct = 0;
    private $totalPage = 0;

    private $currentPage = 1;
    public function __construct()
    {
        //
    }

    public function getProduct($limit, $page, $productName, $sellerName)
    {
        $token = config('app.baleomol_token_auth');
        $url = config('app.baleomol_url') . '/suppliers?req=affilio';
        if ($limit) {
            $url .= '&limit=' . (int)$limit;
        }

        if ($page) {
            $url .= '&page=' . $page;
        }

        if ($productName) {
            $url .= '&productName=' . $productName;
        }

        if ($sellerName) {
            $url .= '&sellerName=' . $sellerName;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get($url);

        $data = $response['data'] ?? [];
        $results = $data['results'] ?? [];
        $pagination = $data['pagination'] ?? [];
        $this->totalProduct = $pagination['totalData'] ?? 0;
        $this->totalPage = $pagination['totalPage'] ?? 0;

        return  $results ?? [];
    }

    public function getTotalSupplier()
    {
        //return SupplierList::whereNull('deleted_at')->count();
    }
    public function getDataTable($request)
    {
        $limit = $request->input('length') ?? 20;
        $start = $request->input('start') ?? 1;
        $productName = $request->input('productName') ?? '';
        $page = (floor($start / $limit)) + 1;
        $sellerName = $request->input('sellerName') ?? '';

        $products = $this->getProduct($limit, $page, $productName, $sellerName);
        $total_data = $this->totalProduct;

        $data = [];

        if (!empty($products)) {
            foreach ($products  as $product) {
                $productName = $product['productName'];
                $sellerName = $product['sellerName'];
                $priceFormat = $product['priceFormat'];
                $picture = $product['picture'];
                $priceFormat = $product['price'];
                $sellPriceFormat = $product['sellPrice'];


                $data[] = [
                    'productName' => $productName,
                    'sellerName' => $sellerName,
                    'priceFormat' => $priceFormat,
                    'picture' => $picture,
                    'priceFormat' => formatRupiah($priceFormat),
                    'sellPriceFormat' => formatRupiah($sellPriceFormat),
                ];
            }
        }

        $result = [
            'draw' => $page,
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data,
        ];

        return $result;
    }
}
