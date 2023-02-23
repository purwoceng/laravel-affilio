<?php

namespace App\Repositories\Content\Banner;

use App\Models\Banner;
use App\Repositories\Interfaces\Content\Banner\BannerRepositoryInterface;

class BannerRepository implements BannerRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create($data)
    {
        return Banner::create($data);
    }

    public function update($id, array $data)
    {
        return Banner::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Banner::where('id', $id)->forcedelete();
    }

    public function getDataById($id)
    {
        return Banner::where('id', $id)->first();
    }

    public function getData($limit, $start)
    {
        return Banner::with('category_type')->whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return Banner::whereNull('deleted_at')->count();
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
                $category_type = '';
                $position = $banner->position;
                $position_label = implode(' ', explode('_', $banner->position));
                $type = $banner->type;
                $name = $banner->name;
                $image = $banner->image;
                $image_url = $banner->image ? config('app.s3_url') . $banner->image : '';
                $target_url = $banner->target_url;
                $description = $banner->description;
                $created_at = $banner->created_at->format('Y-m-d H:i:s');

                $data[] = compact(
                    'id',
                    'category_type',
                    'type',
                    'name',
                    'image',
                    'image_url',
                    'target_url',
                    'position',
                    'position_label',
                    'description',
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
