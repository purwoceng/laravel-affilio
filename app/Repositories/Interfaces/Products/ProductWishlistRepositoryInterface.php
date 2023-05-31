<?php

namespace App\Repositories\Interfaces\Products;

interface ProductWishlistRepositoryInterface
{
    public function getData($limit, $start, $startDate, $endDate);

    public function getTotalData($startDate, $endDate);

    public function getDataTable($request);

    public function getDataById($id);

    public function getCountWishlist($startDate, $endDate);
}
