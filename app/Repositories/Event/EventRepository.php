<?php

namespace App\Repositories\Event;

use App\Models\Event;
use App\Repositories\Interfaces\Event\EventRepositoryInterface;

class EventRepository implements EventRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create($data)
    {
        return Event::create($data);
    }

    public function update($id, array $data)
    {
        return Event::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Event::where('id', $id)->forcedelete();
    }

    public function getDataById($id)
    {
        return Event::where('id', $id)->first();
    }

    public function getData($limit, $start)
    {
        return Event::whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return Event::whereNull('deleted_at')->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getData($limit, $start);
        $totalData = $this->getTotalData();
        $totalFiltered = $totalData;

        $getResults = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($getResults)) {
            foreach ($getResults as $key => $event) {
                $id = $event->id;
                $name = $event->name;
                $speaker = $event->speaker;
                $time = $event->time;
                $date = $event->date;
                $location = $event->location;
                $image = $event->image ? config('app.s3_url') . $event->image : '';
                $type = $event->type;
                $description = $event->description;
                $created_at = date('d/m/Y H:i', strtotime($event->created_at));

                $data[] = compact(
                    'id',
                    'name',
                    'speaker',
                    'time',
                    'date',
                    'location',
                    'image',
                    'type',
                    'description',
                    'created_at',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return response()->json($result);
    }
}
