<?php

namespace App\Repositories\Member;

use App\Models\MemberAccount;
use App\Repositories\Interfaces\Member\MemberAccountRepositoryInterface;

class MemberAccountRepository implements MemberAccountRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getMemberActive($limit, $start)
    {
        return MemberAccount::where('is_deleted',0)->offset($start)->limit($limit);
    }

    public function getCountMemberActive()
    {
        return MemberAccount::where('is_deleted',0)->count();
    }

    public function getDataById($id)
    {
        return MemberAccount::where('id', $id)->first();
    }

    public function getData($limit, $start)
    {
        return MemberAccount::with('member_type')->whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getMemberActive($limit, $start);
        $totalData = $this->getCountMemberActive();
        $totalFiltered = $totalData;



        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $getQuery->where('username', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('bank_name')) {
            $keyword = $request->get('bank_name');
            $getQuery->where('bank_name', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('account_name')) {
            $keyword = $request->get('account_name');
            $getQuery->where('account_name', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('account_number')) {
            $keyword = $request->get('account_number');
            $getQuery->where('account_number', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('publish')) {
            if ($request->publish != 'all') {
                $keyword = $request->get('publish');
                $getQuery->where('publish', $keyword);
                $totalData = $getQuery->count();
                $totalFiltered = $totalData;
            }
        }

        $getMemberAccounts = $getQuery->orderBy('id', 'desc')->get();

        $dataArray = [];
        if (!empty($getMemberAccounts)) {
            foreach ($getMemberAccounts as $key => $value) {
                $id = $value->id;
                $username = $value->username;
                $bank_name = $value->bank_name;
                $account_number = $value->account_number;
                $account_name = $value->account_name;
                $publish = $value->publish;
                $is_deleted = $value->is_deleted;

                $dataArray[] = [
                    'id' => $id,
                    'username' => $username,
                    'bank_name' => $bank_name,
                    'account_number' => $account_number,
                    'account_name' => $account_name,
                    'publish' => $publish,
                    'is_deleted' => $is_deleted,
                    'actions' => $id,
                ];
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $dataArray
        );

        echo json_encode($json_data);
    }
}
