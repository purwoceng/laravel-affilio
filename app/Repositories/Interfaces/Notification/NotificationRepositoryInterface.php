<?php

namespace App\Repositories\Interfaces\Notification;

interface NotificationRepositoryInterface
{
    public function getNotification($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountNotification();

    public function getDataTable($request);
}
