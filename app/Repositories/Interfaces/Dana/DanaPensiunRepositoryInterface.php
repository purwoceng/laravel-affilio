<?php

namespace App\Repositories\Interfaces\Dana;

interface DanaPensiunRepositoryInterface
{
    public function getCountDanaPensiun($startDate, $endDate);

    public function getDanaPensiun($limit, $start, $startDate, $endDate);

    public function getDataTable($request);
}
