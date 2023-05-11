<?php

namespace App\Repositories\Interfaces\Dana;

interface FundsRepositoryInterface
{
    public function getCountFund($startDate, $endDate);
    public function getFund($limit, $start, $startDate, $endDate);
    public function getDataTable($request);
}
