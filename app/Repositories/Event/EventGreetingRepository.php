<?php

namespace App\Repositories\Event;

use App\Models\EventGreeting;
use App\Repositories\Interfaces\Event\EventGreetingRepositoryInterface;

class EventGreetingRepository implements EventGreetingRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return EventGreeting::create($data);
    }

    public function update($id, array $data)
    {
        return EventGreeting::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return EventGreeting::where('id', $id)->delete();
    }

    public function getGreetingById($id)
    {
        return EventGreeting::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountGreeting()
    {
        return EventGreeting::all()->count();
    }

    public function getGreeting($limit, $start)
    {
        return EventGreeting::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $greeting_query = $this->getGreeting($limit, $start);
        $total_data = $this->getCountGreeting();

        $greetings = $greeting_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($greetings)) {
            foreach ($greetings  as $key => $greeting) {
                $id = $greeting->id;
                $title = $greeting->title;
                $thumbnail = $greeting->thumbnail ? config('app.s3_url') . $greeting->thumbnail : '';
                $timer = $greeting->timer;
                $url = $greeting->url;
                $is_active = $greeting->is_active;
                $created_at = date('Y-m-d H:i', strtotime($greeting->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'title',
                    'thumbnail',
                    'timer',
                    'url',
                    'is_active',
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
