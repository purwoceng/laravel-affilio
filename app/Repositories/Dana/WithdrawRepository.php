<?php

namespace App\Repositories\Dana;

use App\Models\Withdraw;
use App\Repositories\Interfaces\Dana\WithdrawRepositoryInterface;

class WithdrawRepository implements WithdrawRepositoryInterface
{



    public function __construct()
    {
        // 
    }

    public function getCountWithdraw($startDate, $endDate)
    {
        return Withdraw::whereBetween('code', ['WDB', 'WDK'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get()->count();
    }

    public function getDataById($id)
    {
        return Withdraw::whereBetween('code', ['WDB', 'WDK'])->where('id', $id)->first();
    }


    public function getWithdraw($limit, $start, $startDate, $endDate)
    {
        return Withdraw::whereBetween('code', ['WDB', 'WDK'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->offset($start)->limit($limit);
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

        $wd_query = $this->getWithdraw($limit, $start, $startDate, $endDate);
        $totalData = $this->getCountWithdraw($startDate, $endDate);
        $totalFiltered = $totalData;

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $wd_query->where('username', 'like', '%' . $keyword . '%');
            $totalData = $wd_query->count();
            $totalFiltered = $totalData;
        }

        $withdraws = $wd_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($withdraws)) {
            foreach ($withdraws  as $key => $withdraw) {
                $id = $withdraw->id;
                $username = $withdraw->username;
                $code = $withdraw->code;
                $title = $withdraw->title;
                $description = $withdraw->description ?? '-';
                $status_verify = $withdraw->status_verify ?? '-';
                $value = $withdraw->value;
                $is_active = $withdraw->is_active ?? '-';
                $publish = $withdraw->publish ?? '-';
                $created_at = date('d/m/Y H:i', strtotime($withdraw->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'username',
                    'code',
                    'title',
                    'description',
                    'status_verify',
                    'value',
                    'is_active',
                    'publish',
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
