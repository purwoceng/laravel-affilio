<?php

namespace App\Repositories\Interfaces\HomePage;

interface SupplierRepositoryInterface
{
    
    public function getSupplierHomes($limit, $start);

    public function getSupplierHomeById($id);

    public function getDataTable($request);
}
