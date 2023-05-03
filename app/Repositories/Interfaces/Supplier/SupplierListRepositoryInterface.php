<?php

namespace App\Repositories\Interfaces\Supplier;

interface SupplierListRepositoryInterface
{
    public function getDataTable($request);
    public function getSupplier($limit, $start, $username, $storeName);

    public function getTotalSupplier();
}
