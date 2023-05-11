<?php

namespace App\Repositories\Interfaces\Invoice\Unpaid;

interface InvoiceUnpaidRepositoryInterface
{
    public function getData($limit, $start);

    public function getTotalData();

    public function getDataTable($request);

    public function getDataById($id);
}
