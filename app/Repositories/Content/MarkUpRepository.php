<?php

namespace App\Repositories\content;

use App\Models\markup;
use App\Repositories\Interfaces\content\MarkUpRepositoryInterface;

class MarkUpRepository implements MarkUpRepositoryInterface
{

    public function __construct()
    {
        //
    }

    public function getMarkUP($limit, $start)
    {
        return markup::where('publish', '1')->offset($start)->limit($limit);
    }

    public function getCountMarkUP()
    {
        return markup::where('publish', '1')->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getMarkUP($limit, $start);
        $totalData = $this->getCountMarkUP();
        $totalFiltered = $totalData;


        $getmarkupBlockeds = $getQuery->orderBy('id', 'desc')->get();

        $dataArray = [];
        if (!empty($getmarkupBlockeds)) {
            foreach ($getmarkupBlockeds as $key => $getmarkupBlocked) {
                $id = $getmarkupBlocked->id;
                $markup = $getmarkupBlocked->markup;
                $isVerified = $getmarkupBlocked->is_verified;
                $isBlocked = $getmarkupBlocked->is_blocked;

                $dataArray[] = [
                    'id' => $id,
                    'markup' => $markup,
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
}
