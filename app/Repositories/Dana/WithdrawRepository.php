<?php

namespace App\Repositories\Dana;

use App\Models\Withdraw;
use Illuminate\Support\Facades\DB;
use App\Repositories\Interfaces\Dana\WithdrawRepositoryInterface;

class WithdrawRepository implements WithdrawRepositoryInterface
{



    public function __construct()
    {
        //
    }

    public function getCountWithdraw($startDate, $endDate)
    {
        return Withdraw::with('members')->whereBetween('code', ['WDB', 'WDK'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
    }

    public function getDataById($id)
    {
        return Withdraw::whereBetween('code', ['WDB', 'WDK'])->where('id', $id)->first();
    }


    public function getWithdraw($limit, $start, $startDate, $endDate)
    {
        return Withdraw::with('members')->whereBetween('code', ['WDB', 'WDK'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->offset($start)->limit($limit);
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
        $getQueryTotal = $this->getCountWithdraw($startDate, $endDate);
       // $totalFiltered = $totalData;

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $wd_query->where('username', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('username', 'like', '%' . $keyword . '%');

        }

        if ($request->filled('code')) {
            if ($request->code != 'all') {
                $keyword = $request->get('code');
                $wd_query->where('code', $keyword);
                $getQueryTotal->where('code', $keyword);

            }
        }
        if ($request->filled('publish')) {
            if ($request->publish != 'all') {
                $keyword = $request->get('publish');
                $wd_query->where('publish', $keyword);
                $getQueryTotal->where('publish', $keyword);
            }
        }
        if ($request->filled('email')) {
            if ($request->email != 'all') {
                $keyword = $request->get('email');
                $wd_query->whereHas('members', function ($query) use ($keyword) {
                    return $query->where('members.publish', '=', 1)->where('members.email', 'LIKE', '%' . $keyword . '%');
                });

                $getQueryTotal->whereHas('members', function ($query) use ($keyword) {
                    return $query->where('members.publish', '=', 1)->where('members.email', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        $totalData = $getQueryTotal->count();
        $totalFiltered = $totalData;
        $withdraws = $wd_query->orderBy('id', 'desc')->get();

        $data =  [];

        if (!empty($withdraws)) {
            foreach ($withdraws  as $key => $withdraw) {
                $id = $withdraw->id;
                $username = $withdraw->username;
                $email = $withdraw->members->email ?? '-';
                $code = $withdraw->code;
                $title = $withdraw->title;
                $description = $withdraw->description ?? '-';
                $status_transfer = $withdraw->status_transfer ?? '-';
                $value = $withdraw->value;
                $pajak = $withdraw->value * 6/100;
                $total_transfer = $withdraw-> value - $pajak;
                $is_active = $withdraw->is_active ?? '-';
                $publish = $withdraw->publish ?? '-';
                $created_at = date('d/m/Y H:i', strtotime($withdraw->created_at));
                $actions = $id;

                $data[] = array(
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'code' => $code,
                    'title' => $title,
                    'description' => $description,
                    'status_transfer' => $status_transfer,
                    'value' => number_format($value),
                    'pajak' => number_format($pajak),
                    'total_transfer' => number_format($total_transfer),
                    'is_active' => $is_active,
                    'publish' => $publish,
                    'created_at' => $created_at,
                    'actions' => $actions,
                );
            }
        }

        //$data['total_transfer'] = $total_transfer;

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return $result;
    }
}
