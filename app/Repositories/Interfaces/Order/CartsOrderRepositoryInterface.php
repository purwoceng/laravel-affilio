<?php

namespace App\Repositories\Interfaces\Order;

interface CartsOrderRepositoryInterface
{
    public function getData($limit, $start, $startDate, $endDate);

    public function getTotalData($startDate, $endDate);

    public function getDataTable($request);

    public function getDataById($id);

    public function getCount($startDate, $endDate);

    public function delete($id);
}
