<?php

namespace App\Repositories\Dana;

use App\Models\RewardDana;
use App\Repositories\Interfaces\Dana\RewardRepositoryInterface;

class RewardRepository implements RewardRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getCountRewardDana($startDate, $endDate)
    {
        return RewardDana::where('code', 'ka')->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get()->count();
    }
    public function getDataById($id)
    {
        return RewardDana::where('code', 'ka')->where('id', $id)->first();
    }


    public function getRewardDana($limit, $start, $startDate, $endDate)
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

        $reward_query = $this->getRewardDana($limit, $start, $startDate, $endDate);
        $totalData = $this->getCountRewardDana($startDate, $endDate);
        $totalFiltered = $totalData;

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $reward_query->where('username', 'like', '%' . $keyword . '%');
            $totalData = $reward_query->count();
            $totalFiltered = $totalData;
        }

        $rewards = $reward_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($rewards)) {
            foreach ($rewards  as $key => $reward) {
                $id = $reward->id;
                $username = $reward->username;
                $code = $reward->code;
                $title = $reward->title;
                $description = $reward->description;
                $status_verify = $reward->status_verify ?? '-';
                $value = $reward->value;
                $created_at = date('d/m/Y H:i', strtotime($reward->created_at));
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
