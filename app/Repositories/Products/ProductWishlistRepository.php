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

    public function getData($limit, $start)
    {
       return ProductWishlist::limit($limit)->offset($start);
    }

    public function getTotalData()
    {
        return ProductWishlist::all()->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $query = $this->getData($limit, $start);
        $totalData = $this->getTotalData();

        $getDatas = $query->orderBy('id','desc')->get();

        $totalFilteredData = $totalData;

        $data = [];

        if (!empty($getDatas)) {
            foreach ($getDatas as $key => $value) {
                $id = $value->id;
                $product_id = $value->product_id;

                $memberId = $value->member_id;
                $member = Member::where('id',$memberId)->first();
                $member_name = $member->name ?? '-';

                $token = config('app.baleomol_key');
                $url = config('app.baleomol_url') . '/products/' . $product_id;

                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                ])->get($url);

                $product_data = $response['data'];
                $product_image = $product_data['picture'][0];


                $data[] = compact(
                    'id',
                    'product_image',
                    'member_name',
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
