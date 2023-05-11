<?php

namespace App\Repositories\Interfaces\Dana;

interface EventfundRepositoryInterface
{
    public function getCountEventFund($startDate, $endDate);
    public function getEventFund($limit, $start, $startDate, $endDate);
    public function getDataTable($request);
}
