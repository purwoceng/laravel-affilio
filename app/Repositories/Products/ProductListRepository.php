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
        $url = config('app.baleomol_url') . '/affiliator/products?appx=true';
        if ($limit) {
            $url .= '&limit=' . (int)$limit;
        }

        if ($page) {
            $url .= '&page=' . $page;
        }

        if ($productName) {
            $url .= '&name=' . $productName;
        }

        if ($sellerName) {
            $url .= '&sellerUsername=' . $sellerName;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get($url);

        $data = $response['data']['data'] ?? [];
        // $results = $data['results'] ?? [];

        // dd($data);
        // exit;

        // $pagination = $data['pagination'] ?? [];
        // $this->totalProduct = $pagination['totalData'] ?? 0;
        // $this->totalPage = $pagination['totalPage'] ?? 0;

        return  $data ?? [];
    }

    public function getTotalSupplier()
    {
        //return SupplierList::whereNull('deleted_at')->count();
    }
    public function getDataTable($request)
    {
        $limit = $request->input('length') ?? 20;
        $start = $request->input('start') ?? 1;
        $productName = $request->input('name') ?? '';
        $page = (floor($start / $limit)) + 1;
        $sellerName = $request->input('sellerUsername') ?? '';

        $products = $this->getProduct($limit, $page, $productName, $sellerName);
        // $total_data = $this->totalProduct;

        $total_data = count($this->getProduct($limit, $page, $productName, $sellerName));

        $data = [];

        if (!empty($products)) {
            foreach ($products  as $product) {
                $productName = $product['name'];
                $sellerName = $product['sellerUsername'];
                $priceFormat = $product['priceFormat'];
                $picture = $product['image'];
                $priceFormat = $product['price'];
                $sellPriceFormat = $product['sellPrice'];


                $data[] = [
                    'name' => $productName,
                    'sellerUsername' => $sellerName,
                    'price' => $priceFormat,
                    'image' => $picture,
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
