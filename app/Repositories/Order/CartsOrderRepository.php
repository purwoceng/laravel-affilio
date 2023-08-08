<?php

namespace App\Repositories\Order;

use App\Models\Member;
use App\Models\CartsOrder;
use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\Order\CartsOrderRepositoryInterface;

class CartsOrderRepository implements CartsOrderRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getCount($startDate, $endDate)
    {
        return CartsOrder::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
    }

    public function delete($id)
    {
        return CartsOrder::where('id',$id)->delete();
    }

    public function getData($limit, $start, $startDate, $endDate)
    {
        return CartsOrder::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->offset($start)->limit($limit);
    }

    public function getTotalData($startDate, $endDate)
    {
        return CartsOrder::whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate);
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

        $query = $this->getData($limit, $start, $startDate, $endDate);
        $getQueryTotal = $this->getTotalData($startDate, $endDate);
        //$totalFilteredData = $totalData;

        if ($request->filled('affiliator_username')) {
            $keyword = $request->get('affiliator_username');
            $query->where('affiliator_username', 'like', '%' . $keyword . '%');
            $getQueryTotal->where('affiliator_username', 'like', '%' . $keyword . '%');
        }

        // if ($request->filled('username')) {
        //     if ($request->username != 'all') {
        //         $keyword = $request->get('username');
        //         $query->whereHas('members', function ($query1) use ($keyword) {
        //             return $query1->where('members.publish', '=', 1)->where('members.username', 'LIKE', '%' . $keyword . '%');
        //         });
        //         $getQueryTotal->whereHas('members', function ($query1) use ($keyword) {
        //             return $query1->where('members.publish', '=', 1)->where('members.username', 'LIKE', '%' . $keyword . '%');
        //         });

        //     }
        // }


        $totalData = $getQueryTotal->count();
        $totalFiltered = $totalData;
        $getDatas = $query->orderBy('id', 'desc')->get();
        $data = [];

        if (!empty($getDatas)) {
            foreach ($getDatas as $key => $value) {
                $id = $value->id;
                $product_id = $value->product_id ?? '-';
                $memberId = $value->member_id;
                $created_at = date(' d F Y H:i', strtotime($value->created_at));
                $member = Member::where('id', $memberId)->first();
                // $member_name = $member->name ?? '-';
                $member_name = $value->affiliator_username ?? '-';
                $product_variation_name = $value->product_variation_name ?? '-';
                $quantity = $value->quantity ?? '-';
                $platform = $value->platform?? '-';

                // $token = config('app.baleomol_token_auth');
                // $url = config('app.baleomol_url') . '/affiliator/products/' . $product_id . '?appx=true';


                // $response = Http::withHeaders([
                //     'Authorization' => "Bearer {$token}",
                // ])->get($url);

                // $product_data = $response['data'] ?? [];
                // $product_image = $product_data['media'][1] ?? [];


                $data[] = compact(
                    'id',
                    // 'product_image',
                    // 'product_data',
                    'product_id',
                    'member_name',
                    'product_variation_name',
                    'platform',
                    'quantity',
                    'created_at',
                );
            }
        }


        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return response()->json($result);
    }

    public function getDataById($id)
    {
    }
}
