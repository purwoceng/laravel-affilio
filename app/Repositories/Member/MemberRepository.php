<?php

namespace App\Repositories\Member;

use App\Models\Member;
use App\Repositories\Interfaces\Member\MemberRepositoryInterface;

class MemberRepository implements MemberRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getMemberActive($limit, $start)
    {
        return Member::where('publish', '1')->offset($start)->limit($limit);
    }

    public function getCountMemberActive()
    {
        return Member::where('publish', '1')->count();
    }

    public function getDataById($id)
    {
        return Member::where('id', $id)->first();
    }

    public function getData($limit, $start)
    {
        return Member::with('member_type')->whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getMemberActive($limit, $start);
        $totalData = $this->getCountMemberActive();
        $totalFiltered = $totalData;

        if ($request->filled('name')) {
            $keyword = $request->get('name');
            $getQuery->where('name', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $getQuery->where('username', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('email')) {
            $keyword = $request->get('email');
            $getQuery->where('email', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('phone')) {
            $keyword = $request->get('phone');
            $getQuery->where('phone', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        $getMemberBlockeds = $getQuery->orderBy('id', 'desc')->get();

        $dataArray = [];
        if (!empty($getMemberBlockeds)) {
            foreach ($getMemberBlockeds as $key => $getMemberBlocked) {
                $id = $getMemberBlocked->id;
                $username = $getMemberBlocked->username;
                $email = $getMemberBlocked->email;
                $phone = $getMemberBlocked->phone;
                $name = $getMemberBlocked->name;
                $member_type = $getMemberBlocked->member_type->type;
                $isVerified = $getMemberBlocked->is_verified;
                $isBlocked = $getMemberBlocked->is_blocked;

                $dataArray[] = [
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'phone' => $phone,
                    'name' => $name,
                    'member_type' => $member_type,
                    'is_verified' => $isVerified,
                    'is_blocked' => $isBlocked,
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
