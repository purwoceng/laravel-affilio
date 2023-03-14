<?php

namespace App\Repositories\Notification;

use App\Models\Notification;
use App\Repositories\Interfaces\Notification\NotificationRepositoryInterface;

class NotificationRepository implements NotificationRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return Notification::create($data);
    }

    public function update($id, array $data)
    {
        return Notification::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return Notification::where('id',$id)->delete();
    }

    public function getNotificationById($id)
    {
        return Notification::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountNotification()
    {
        return Notification::all()->count();
    }

    public function getNotification($limit, $start)
    {
        return Notification::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $notification_query = $this->getNotification($limit, $start);
        $total_data = $this->getCountNotification();

        $notifications = $notification_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($notifications)) {
            foreach ($notifications  as $key => $notif) {
                $id = $notif->id;
                $categories = $notif->categories;
                $notification = $notif->notification;
                $created_at = date('Y-m-d H:i', strtotime($notif->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'categories',
                    'notification',
                    'created_at',
                    'actions',

                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data,
        ];

        return $result;
    }
}
