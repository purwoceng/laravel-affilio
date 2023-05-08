<?php

namespace App\Repositories\Notification;

use App\Models\NotificationStatus;
use App\Repositories\Interfaces\Notification\NotificationStatusRepositoryInterface;

class NotificationStatusRepository implements NotificationStatusRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return NotificationStatus::create($data);
    }

    public function update($id, array $data)
    {
        return NotificationStatus::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return NotificationStatus::where('id',$id)->delete();
    }

    public function getNotificationById($id)
    {
        return NotificationStatus::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountNotificationStatus()
    {
        return NotificationStatus::where('creator_id','0')->count();
    }

    public function getNotificationStatus($limit, $start)
    {
        return NotificationStatus::where('creator_id', '0')->offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $notification_query = $this->getNotificationStatus($limit, $start);
        $total_data = $this->getCountNotificationStatus();

        $notifications = $notification_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($notifications)) {
            foreach ($notifications  as $key => $notif) {
                $id = $notif->id;
                $member_id = $notif->member_id;
                $notification_id = $notif->notification_id;
                $created_at = date('Y-m-d H:i', strtotime($notif->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'member_id',
                    'notification_id',
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
