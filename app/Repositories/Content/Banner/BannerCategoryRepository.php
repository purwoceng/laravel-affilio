<?php

namespace App\Repositories\Content\Banner;

use App\Models\BannerCategory;
use App\Repositories\Interfaces\Content\Banner\BannerCategoryRepositoryInterface;

class BannerCategoryRepository implements BannerCategoryRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create($data)
    {
        return BannerCategory::create($data);
    }

    public function update($id, array $data)
    {
        return BannerCategory::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return BannerCategory::where('id',$id)->delete();
    }

    public function getDataById($id)
    {
        return BannerCategory::where('id',$id)->first();
    }

    public function getData($limit, $start)
    {
        return BannerCategory::whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return BannerCategory::whereNull('deleted_at')->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getData($limit, $start);
        $totalData = $this->getTotalData();
        $totalFiltered = $totalData;

        $getResults = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($getResults)) {
            foreach ($getResults  as $key => $banner) {
                $id = $banner->id;
                $name = $banner->name;
                $code = $banner->code;
                $created_at = $banner->created_at->format('Y-m-d H:i:s');

                $data[] = compact(
                    'id',
                    'name',
                    'code',
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
}
