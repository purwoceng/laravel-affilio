<?php

namespace App\Repositories\Interfaces\Invoice\Cancel;

interface InvoiceCancelRepositoryInterface
{
    public function getData($limit, $start);

    public function getTotalData();

    public function getDataTable($request);

    public function getDataById($id);
}
