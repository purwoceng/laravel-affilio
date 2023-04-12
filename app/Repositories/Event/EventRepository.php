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
                $price = $event->price;
                $tiket = $event->tiket;
                $kuota = $event->kuota;
                $time = $event->time;
                $date = $event->date;
                $location = $event->location;
                $prefix = $event->prefix;
                $image = $event->image ? config('app.s3_url') . $event->image : '';
                $video = $event->video;
                $type = $event->type;
                $description = $event->description;
                $status = $event->status;
                $created_at = date('d/m/Y H:i', strtotime($event->created_at));

                $data[] = compact(
                    'id',
                    'name',
                    'speaker',
                    'price',
                    'tiket',
                    'kuota',
                    'time',
                    'date',
                    'location',
                    'prefix',
                    'image',
                    'video',
                    'type',
                    'description',
                    'status',
                    'created_at',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordFiltered' => intval($totalData),
            'data' => $data,
        ];

        return response()->json($result);
    }
}
