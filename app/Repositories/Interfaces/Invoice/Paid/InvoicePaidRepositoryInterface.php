<?php

namespace App\Repositories\Interfaces\Invoice\Paid;

interface InvoicePaidRepositoryInterface
{
    public function getData($limit, $start);

    public function getTotalData();

    public function getDataTable($request);
}
