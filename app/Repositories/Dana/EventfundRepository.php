<?php

namespace App\Repositories\Dana;

use App\Models\RewardDana;
use App\Repositories\Interfaces\Dana\EventfundRepositoryInterface;

class EventfundRepository implements EventfundRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getCountEventFund($startDate, $endDate)
    {
        return RewardDana::where('code', 'ka')->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get()->count();
    }
    public function getDataById($id)
    {
        return RewardDana::where('code', 'ka')->where('id', $id)->first();
    }


    public function getEventFund($limit, $start, $startDate, $endDate)
    {
        return RewardDana::where('code', 'ka')->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        if (!empty($request->date_range)) {
            $dateRange = $request->date_range;
            $date = explode("/", $dateRange);;
            $startDate = $date[0];
            $endDate = $date[1];
        } else {
            $now = date('Y-m-d');
            $startDate = $now;
            $endDate = $now;
        }

        $event_query = $this->getEventFund($limit, $start, $startDate, $endDate);
        $totalData = $this->getCountEventFund($startDate, $endDate);
        $totalFiltered = $totalData;

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $event_query->where('username', 'like', '%' . $keyword . '%');
            $totalData = $event_query->count();
            $totalFiltered = $totalData;
        }

        $events = $event_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($events)) {
            foreach ($events  as $key => $event) {
                $id = $event->id;
                $username = $event->username;
                $code = $event->code;
                $title = $event->title;
                $description = $event->description ?? '-';
                $status_verify = $event->status_verify ?? '-';
                $value = $event->value;
                $created_at = date('d/m/Y H:i', strtotime($event->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'username',
                    'code',
                    'title',
                    'description',
                    'status_verify',
                    'value',
                    'created_at',
                    'actions',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalData),
            'data' => $data,
        ];

        return $result;
    }
}
