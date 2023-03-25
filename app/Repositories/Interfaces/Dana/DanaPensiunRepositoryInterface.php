<?php

namespace App\Repositories\Interfaces\Dana;

interface DanaPensiunRepositoryInterface
{
    public function getCountDanaPensiun();

    public function getDanaPensiun($limit, $start);

    public function getDataTable($request);

    // public function getData($limit, $start, $startDate, $endDate);

    // public function getTotalData($startDate, $endDate);
}
