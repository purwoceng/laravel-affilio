<?php

namespace App\Repositories\Interfaces\Content;

interface GlobalSettingRepositoryInterface
{
    public function getMarkupProduct($limit, $start);

    public function getDataTable($request);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getDataById($id);
}
