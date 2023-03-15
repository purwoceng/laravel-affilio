<?php

namespace App\Repositories\Interfaces\Dana;

interface RewardRepositoryInterface
{
    public function getCountRewardDana();
    public function getRewardDana($limit, $start);
    public function getDataTable($request);
}
