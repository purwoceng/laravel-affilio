<?php

namespace App\Repositories\Interfaces\Products;

interface ProductListRepositoryInterface
{
    public function getDataTable($request);
    public function getProduct($limit, $page, $productName, $sellerName );

}
