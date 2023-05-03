<?php

namespace App\Repositories\Interfaces\Dana;

interface WithdrawRepositoryInterface
{
    public function getCountWithdraw($startDate, $endDate);

    public function getWithdraw($limit, $start, $startDate, $endDate);

    public function getDataTable($request);
}
