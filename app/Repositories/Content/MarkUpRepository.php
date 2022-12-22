<?php

namespace App\Repositories\content;

use App\Models\Markup;
use App\Repositories\Interfaces\content\MarkUpRepositoryInterface;


class MarkUpRepository implements MarkUpRepositoryInterface
{

    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return Markup::create($data);
    }

    public function update($id, array $data)
    {
        return Markup::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Markup::where('id', $id)->delete();
    }




    public function getMarkUP($limit, $start)
    {
        return Markup::offset($start)->limit($limit);
    }

    public function getCountMarkUP()
    {
        return Markup::count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getMarkUP($limit, $start);
        $totalData = $this->getCountMarkUP();
        $totalFiltered = $totalData;


        $getmarkup = $getQuery->orderBy('id', 'desc')->get();

        $dataArray = [];
        if (!empty($getmarkup)) {
            foreach ($getmarkup as $key => $getmarkup) {
                $id = $getmarkup->id;
                $markup = $getmarkup->markup;
                $creted_at = date('Y-m-d H:i', strtotime($getmarkup->created_at));


                $dataArray[] = [
                    'id' => $id,
                    'markup' => $markup,
                    'created_at' => $creted_at,
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
    public function getDataById($id)
    {
        return Markup::where('id', $id)->first();
    }
}
