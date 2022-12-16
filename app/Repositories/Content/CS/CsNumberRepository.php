<?php

namespace App\Repositories\Content\CS;

use App\Models\CsNumber;
use App\Repositories\Interfaces\Content\CS\CsNumberRepositoryInterface;

class CsNumberRepository implements CsNumberRepositoryInterface
{
    public function __construct()
    {
        //
    }

    // public function getData($limit, $start);

    // public function getTotalData();

    // public function getDataTable($request);

    // public function create(array $data);

    // public function update($id, array $data);

    // public function delete($id);

    // public function getDataById($id);


    public function create(array $data)
    {
        return CsNumber::create($data);
    }

    public function update($id, array $data)
    {
        return CsNumber::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return CsNumber::where('id',$id)->delete();
    }

    public function getDataById($id)
    {
        return CsNumber::where('id',$id)->first();
    }

    public function getData($limit, $start)
    {
        return CsNumber::with('category_type')->whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return CsNumber::whereNull('deleted_at')->count();
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
            foreach ($getResults  as $key => $result) {
                $id = $result->id;
                $category_type = $result->category_type->name;
                $name = $result->name;
                $number = $result->number;
                $created_at = $result->created_at->format('Y-m-d H:i:s');

                $data[] = compact(
                    'id',
                    'category_type',
                    'name',
                    'number',
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
