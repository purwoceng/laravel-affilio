<?php

namespace App\Repositories\interfaces\Products;

interface ProductAffilioRepositoryInterface
{
    public function getProductAffilioTypes($limit, $start);

    public function getProductAffilioTypeById($id);

    public function getProductAffilioTypeDataTable($request);

    public function getProductAffilio($limit, $start);

    public function getProductAffilioById($id);

    public function getDataTable($request);
}
