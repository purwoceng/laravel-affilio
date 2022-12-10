<?php

namespace App\Repositories\Interfaces\Invoice;

interface InvoiceRepositoryInterface
{
    public function getInvoices($limit, $start);

    public function getTotalInvoices();

    public function getDataTable($request);
}
