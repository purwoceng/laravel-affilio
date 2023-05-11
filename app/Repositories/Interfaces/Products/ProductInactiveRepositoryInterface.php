<?php

namespace App\Repositories\Interfaces\Products;

interface ProductInactiveRepositoryInterface
{
    public function getDataTable($request);

    public function getInactiveProducts($limit, $start);

    public function removeInactiveProduct($id);

    public function getTotalInactiveProducts();
}
