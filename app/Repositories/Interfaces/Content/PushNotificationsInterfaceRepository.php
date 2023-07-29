<?php

namespace App\Repositories\Interfaces\Content;

interface PushNotificationsInterfaceRepository
{
    public function getData($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountData();

    public function getDataTable($request);
}
