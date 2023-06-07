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
        return Member::with('member_addresses')->where('publish', '1')->offset($start)->limit($limit);
    }

    public function getCountMemberActive()
    {
        return Member::with('member_addresses')->where('publish', '1');
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
        $getQueryTotal = $this->getCountMemberActive();

        if ($request->filled('name')) {
            $keyword = $request->get('name');
            $getQuery->where('name', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('name', 'like', '%' . $keyword . '%');
        }

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $getQuery->where('username', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('username', 'like', '%' . $keyword . '%');
        }

        if ($request->filled('email')) {
            $keyword = $request->get('email');
            $getQuery->where('email', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('email', 'like', '%' . $keyword . '%');
        }

        if ($request->filled('phone')) {
            $keyword = $request->get('phone');
            $getQuery->where('phone', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('phone', 'like', '%' . $keyword . '%');
        }

        if ($request->filled('member_type')) {
            if ($request->member_type != 'all') {
                $keyword = $request->get('member_type');
                $getQuery->where('member_type_id', $keyword);
                $getQueryTotal->where('member_type_id', $keyword);
            }
        }
        if ($request->filled('is_verified')) {
            if ($request->is_verified != 'all') {
                $keyword = $request->get('is_verified');
                $getQuery->where('is_verified', $keyword);
                $getQueryTotal->where('is_verified', $keyword);
            }
        }
        if ($request->filled('is_founder')) {
            if ($request->is_founder != 'all') {
                $keyword = $request->get('is_founder');
                $getQuery->where('is_founder', $keyword);
                $getQueryTotal->where('is_founder', $keyword);
            }
        }
        if ($request->filled('is_transaction')) {
            if ($request->is_transaction != 'all') {
                $keyword = $request->get('is_transaction');
                $getQuery->where('is_transaction', $keyword);
                $getQueryTotal->where('is_transaction', $keyword);
            }
        }
        if ($request->filled('referral')) {
            if ($request->referral != 'all') {
                $keyword = $request->get('referral');
                $getQuery->where('referral', 'like', '%' . $keyword . '%');
                $getQueryTotal->where('referral', 'like', '%' . $keyword . '%');
            }
        }
        if ($request->filled('city_name')) {
            if ($request->city_name != 'all') {
                $keyword = $request->get('city_name');
                $getQuery->whereHas('member_addresses', function ($query) use ($keyword) {
                    return $query->where('member_addresses.main_address', '=', 1)->where('member_addresses.city_name', 'LIKE', '%' . $keyword . '%');
                });

                $getQueryTotal->whereHas('member_addresses', function ($query) use ($keyword) {
                    return $query->where('member_addresses.main_address', '=', 1)->where('member_addresses.city_name', 'LIKE', '%' . $keyword . '%');
                });
            }
        }

        // if ($request->filled('is_transaction')) {
        //     $keyword = $request->get('is_transaction');
        //     $getQuery->where('is_transaction', 'like', '%' . $keyword . '%');
        //     $totalData = $getQuery->count();
        //     $totalFiltered = $totalData;
        // }

        $totalData = $getQueryTotal->count();
        $totalFiltered = $totalData;

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
                $referral = $getMemberBlocked->referral;
                $is_founder = $getMemberBlocked->is_founder ?? '-';
                $isVerified = $getMemberBlocked->is_verified;
                $isBlocked = $getMemberBlocked->is_blocked;
                $is_transaction = $getMemberBlocked->is_transaction ?? '-';
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
                    'referral' => $referral,
                    'is_founder' => $is_founder,
                    'address' => $address,
                    'city_name' => $city_name,
                    'province_name' => $province_name,
                    'is_verified' => $isVerified,
                    'is_blocked' => $isBlocked,
                    'is_transaction' => $is_transaction,
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
        $query = DB::table('referral_helper')
            ->join('members', 'members.id', '=', 'referral_helper.member_id')
            ->join('member_types', 'member_types.id', '=', 'members.member_type_id')
            ->where('referral_helper.referral_id', $member_id);


        if ($founder_id) {
            $query = $query->join('referral_helper', 'referral_helper.member_id', '=', 'members.id')
                ->where('referral_helper.member_is_founder', 'LIKE', "{$founder_id}.%");
        }

        $result = $query
            ->limit($limit)
            ->offset($offset)
            ->get();

        return $result;
    }
}
