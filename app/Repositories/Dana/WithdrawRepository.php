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
        return Withdraw::with('members')->whereBetween('code', ['WDB', 'WDK'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get()->count();
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
        $totalData = $this->getCountWithdraw($startDate, $endDate);
        $totalFiltered = $totalData;

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $wd_query->where('username', 'like', '%' . $keyword . '%');
            $totalData = $wd_query->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('code')) {
            if ($request->code != 'all') {
                $keyword = $request->get('code');
                $wd_query->where('code', $keyword);
                $totalData = $wd_query->count();
                $totalFiltered = $totalData;
            }
        }
        if ($request->filled('publish')) {
            if ($request->publish != 'all') {
                $keyword = $request->get('publish');
                $wd_query->where('publish', $keyword);
                $totalData = $wd_query->count();
                $totalFiltered = $totalData;
            }
        }

        $total_transfer = Withdraw::select(DB::raw("( value * 6 / 100 ) as total_transfer"))
                        ->where('publish', '1')
                        ->pluck('total_transfer');

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
                    'value' => formatRupiah($value),
                    'pajak' => formatRupiah($pajak),
                    'total_transfer' => formatRupiah($total_transfer),
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
            'recordsFiltered' => intval($totalData),
            'data' => $data,
        ];

        return $result;
    }
}
