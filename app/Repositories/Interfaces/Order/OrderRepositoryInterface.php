<?php

namespace App\Repositories\Interfaces\Order;

interface OrderRepositoryInterface
{
    public function getData($limit, $start);

    public function getTotalData();

    public function getDataTable($request);
}
