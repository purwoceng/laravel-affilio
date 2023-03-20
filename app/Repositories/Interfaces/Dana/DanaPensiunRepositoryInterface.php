<?php

namespace App\Repositories\Interfaces\Dana;

interface DanaPensiunRepositoryInterface
{
    public function getData($limit, $start);

    public function getTotalData();

    public function getDataTable($request);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getDataById($id);
}
