<?php

namespace App\Repositories\Interfaces\Supplier;

interface SupplierCoverRepositoryInterface
{
    public function getSupplierCover($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountSupplierCover();

    public function getDataTable($request);
}
