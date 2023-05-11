<?php

namespace App\Repositories\Interfaces\Dana;

interface RewardRepositoryInterface
{
    public function getCountRewardDana($startDate, $endDate);
    public function getRewardDana($limit, $start, $startDate, $endDate);
    public function getDataTable($request);
}
