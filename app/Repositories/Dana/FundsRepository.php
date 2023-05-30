<?php

namespace App\Repositories\Dana;

use App\Models\Fund;
use App\Repositories\Interfaces\Dana\FundsRepositoryInterface;

class FundsRepository implements FundsRepositoryInterface

{
    public function __construct()
    {
        //
    }

    public function getCountFund($startDate, $endDate)
    {
        return Fund::with('members')->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
    }

    public function getDataById($id)
    {
        return Fund::with('members')->where('id', $id)->first();
    }

    public function getFund($limit, $start, $startDate, $endDate)
    {
        return Fund::with('members')->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->offset($start)->limit($limit);
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
        $fund_query = $this->getFund($limit, $start, $startDate, $endDate);
        $getQueryTotal = $this->getCountFund($startDate, $endDate);


        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $fund_query->where('username', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('username', 'like', '%' . $keyword . '%');
        }

        if ($request->filled('status')) {
            $keyword = $request->get('status');
            $fund_query->where('status', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('status', 'like', '%' . $keyword . '%');
        }

        if ($request->filled('code')) {
            $keyword = $request->get('code');
            $fund_query->where('code', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('code', 'like', '%' . $keyword . '%');
        }
        if ($request->filled('title')) {
            $keyword = $request->get('title');
            $fund_query->where('title', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('title', 'like', '%' . $keyword . '%');
        }
        if ($request->filled('status_transfer')) {
            $keyword = $request->get('status_transfer');
            $fund_query->where('status_transfer', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('status_transfer', 'like', '%' . $keyword . '%');
        }
        if ($request->filled('is_active')) {
            $keyword = $request->get('is_active');
            $fund_query->where('is_active', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('is_active', 'like', '%' . $keyword . '%');
        }

        $totalData = $getQueryTotal->count();
        $totalFiltered = $totalData;
        $funds = $fund_query->orderBy('id', 'desc')->get();
        $data = [];

        if (!empty($funds)) {
            foreach ($funds  as $key => $fund) {
                $id = $fund->id;
                $username = $fund->username;
                $email = $fund->members->email ?? '-';
                $status = $fund->status;
                $code = $fund->code;
                $is_active = $fund->is_active;
                $title = $fund->title;
                $value = $fund->value ?? '-';
                $status_transfer = $fund->status_transfer ?? '-';
                $status_verify = $fund->status_verify ?? '-';
                $created_at = date('d/m/Y H:i', strtotime($fund->created_at));
                $actions = $id;

                $data[] = array(
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'status' => $status,
                    'code' => $code,
                    'is_active' => $is_active,
                    'title' => $title,
                    'value' => $value,
                    'status_transfer' => $status_transfer,
                    'status_verify' => $status_verify,
                    'created_at' => $created_at,
                    'actions' => $actions,
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
