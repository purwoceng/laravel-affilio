<?php

namespace App\Repositories\Member;

use App\Models\Member;
use App\Repositories\Interfaces\Member\MemberRepositoryInterface;
use Illuminate\Support\Facades\DB;

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
        return Member::with('member_type', 'member_addresses')->whereNull('deleted_at')->offset($start)->limit($limit);
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

        if ($request->filled('member_type')) {
            if ($request->member_type != 'all') {
                $keyword = $request->get('member_type');
                $getQuery->where('member_type_id', $keyword);
                $totalData = $getQuery->count();
                $totalFiltered = $totalData;
            }
        }

        if ($request->filled('member_addresses ')) {
            if ($request->city_name != 'all') {
                $keyword = $request->get('city_name');
                $getQuery->where('city_name', $keyword);
                $totalData = $getQuery->count();
                $totalFiltered = $totalData;
            }
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
                $member_type = $getMemberBlocked->member_type->type ?? '-';
                $isVerified = $getMemberBlocked->is_verified;
                $isBlocked = $getMemberBlocked->is_blocked;
                $address = $getMemberBlocked->member_addresses->address ?? '-';
                $city_name = $getMemberBlocked->member_addresses->city_name ?? '-';
                $province_name = $getMemberBlocked->member_addresses->province_name ?? '-';

                $dataArray[] = [
                    'id' => $id,
                    'username' => $username,
                    'email' => $email,
                    'phone' => $phone,
                    'name' => $name,
                    'member_type' => $member_type,
                    'address' => $address,
                    'city_name' => $city_name,
                    'province_name' => $province_name,
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

    public function getDownline($member_id, $generation = 1, $limit = 10, $offset = 0, $founder_id = 0)
    {
        $query = DB::table('member_positions')
            ->join('members', 'members.id', '=', 'member_positions.member_id')
            ->join('member_types', 'member_types.id', '=', 'members.member_type_id')
            ->where('member_positions.member_upline_id', $member_id)
            ->where('member_positions.generation', $generation);

        if ($founder_id) {
            $query = $query->join('member_generations', 'member_generations.member_id', '=', 'members.id')
                ->where('member_generations.networks', 'LIKE', "{$founder_id}.%");
        }

        $result = $query
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $result;
    }
}
