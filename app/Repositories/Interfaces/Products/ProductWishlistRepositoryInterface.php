<?php

namespace App\Repositories\Interfaces\Products;

interface ProductWishlistRepositoryInterface
{
    public function getData($limit, $start);

    public function getTotalData();

    public function getDataTable($request);

    public function getDataById($id);
}
