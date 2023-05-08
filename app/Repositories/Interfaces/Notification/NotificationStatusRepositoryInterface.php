<?php

namespace App\Repositories\Interfaces\Notification;

interface NotificationStatusRepositoryInterface
{
    public function getNotificationStatus($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountNotificationStatus();

    public function getDataTable($request);
}
