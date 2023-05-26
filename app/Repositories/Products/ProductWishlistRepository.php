<?php

namespace App\Repositories\Products;

use App\Models\Member;
use App\Models\ProductWishlist;
use Illuminate\Support\Facades\Http;
use App\Repositories\Interfaces\Products\ProductWishlistRepositoryInterface;

class ProductWishlistRepository implements ProductWishlistRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getCountWishlist($startDate, $endDate)
    {
        return ProductWishlist::whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)->get()->count();
    }

    public function getData($limit, $start, $startDate, $endDate)
    {
       return ProductWishlist::whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)->offset($start)->limit($limit);
    }

    public function getTotalData($startDate, $endDate)
    {
        return ProductWishlist::whereDate('date', '>=', $startDate)->whereDate('date', '<=', $endDate)->get()->count();
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
        $totalData = $this->getTotalData($startDate, $endDate);
        $totalFilteredData = $totalData;

        $getDatas = $query->orderBy('id','desc')->get();

        if ($request->filled('product')) {
            $keyword = $request->get('product');
            $query->where('product_id', 'like', '%' . $keyword . '%');
            $totalData = $query->count();
            $totalFiltered = $totalData;
        }



        $data = [];

        if (!empty($getDatas)) {
            foreach ($getDatas as $key => $value) {
                $id = $value->id;
                $product_id = $value->product_id;

                $memberId = $value->member_id;
                $created_at = date(' d F Y H:i', strtotime($value->date));
                $member = Member::where('id',$memberId)->first();
                $member_name = $member->name ?? '-';

                $token = config('app.baleomol_token_auth');
                $url = config('app.baleomol_url') . '/affiliator/products/' . $product_id;

                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                ])->get($url);

                $product_image = $response['data'];
                //$product_image = $product_data['media'][1] ?? [];


                $data[] = compact(
                    'id',
                    'product_image',
                    'member_name',
                    'created_at',
                );
            }
        }


        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFilteredData),
            'data' => $data,
        ];

        return $result;
    }

    public function getDataById($id)
    {

    }
}
