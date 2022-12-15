<?php

namespace App\Repositories\Content\CS;

use App\Models\CsNumberCategory;
use App\Repositories\Interfaces\Content\CS\CsNumberCategoryRepositoryInterface;

class CsNumberCategoryRepository implements CsNumberCategoryRepositoryInterface
{
    public function __construct()
    {
        //
    }

    // public function create(array $data);
    public function create(array $data)
    {
        return CsNumberCategory::create($data);
    }

    public function update($id, array $data)
    {
        return CsNumberCategory::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return CsNumberCategory::where('id',$id)->delete();
    }

    public function getDataById($id)
    {
        return CsNumberCategory::where('id',$id)->first();
    }

    public function getData($limit, $start)
    {
        return CsNumberCategory::whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return CsNumberCategory::whereNull('deleted_at')->count();
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
            foreach ($getResults  as $key => $category) {
                $id = $category->id;
                $name = $category->name;
                $code = $category->code;
                $created_at = $category->created_at->format('Y-m-d H:i:s');

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
