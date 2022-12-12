<?php

namespace App\Repositories\Interfaces\HomePage;

interface ProductRepositoryInterface
{
    public function getProductHomeTypes($limit, $start);

    public function getProductHomeTypeById($id);

    public function getProductHomeTypeDataTable($request);

    public function getProductHomes($limit, $start);

    public function getProductHomeById($id);

    public function getDataTable($request);
}
