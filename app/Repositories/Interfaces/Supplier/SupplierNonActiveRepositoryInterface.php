<?php

namespace App\Repositories\Interfaces\Supplier;

interface SupplierNonActiveRepositoryInterface
{
    public function create(array $data);

    public function delete($id);

    public function getData($limit, $start);

    public function getTotalData();

    public function getDataTable($request);
}
