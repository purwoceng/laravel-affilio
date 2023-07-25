<?php

namespace App\Repositories\Content;

use App\Models\PushNotification;
use App\Repositories\Interfaces\Content\PushNotificationsInterfaceRepository;

class PushNotificationsRepository implements PushNotificationsInterfaceRepository
{
    public function __construct()
    {
        //
    }
    
    public function create(array $data)
    {
        return PushNotification::create($data);
    }

    public function update($id, array $data)
    {
        return PushNotification::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return PushNotification::where('id', $id)->delete();
    }

    public function getDataById($id)
    {
        return PushNotification::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountData()
    {
        return PushNotification::all()->count();
    }

    public function getData($limit, $start)
    {
        return PushNotification::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $push_query = $this->getData($limit, $start);
        $total_data = $this->getCountData();

        $pushs = $push_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($pushs)) {
            foreach ($pushs  as $key => $push) {
                $id = $push->id;
                $title = $push->title;
                $description = $push->description ?? '-';
                $url = $push->url ?? '-';
                $created_at = date('H:i | d-m-Y', strtotime($push->created_at));
                // $created_at = date('Y-m-d H:i', strtotime($push->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'title',
                    'description',
                    'url',
                    'created_at',
                    // 'created_at',
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
