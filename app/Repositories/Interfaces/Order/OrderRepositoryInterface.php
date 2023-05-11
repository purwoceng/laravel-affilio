<?php

namespace App\Repositories\Interfaces\Order;

interface OrderRepositoryInterface
{
    public function getData($limit, $start, $startDate, $endDate);

    public function getTotalData($startDate, $endDate);

    public function getDataTable($request);
}
