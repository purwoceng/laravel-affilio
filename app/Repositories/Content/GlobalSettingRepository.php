<?php

namespace App\Repositories\content;

use App\Models\GlobalSetting;
use App\Repositories\Interfaces\content\GlobalSettingRepositoryInterface;


class GlobalSettingRepository implements GlobalSettingRepositoryInterface
{

    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return GlobalSetting::create($data);
    }

    public function update($id, array $data)
    {
        return GlobalSetting::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return GlobalSetting::where('id', $id)->delete();
    }




    public function getMarkUP($limit, $start)
    {
        return GlobalSetting::offset($start)->limit($limit);
    }

    public function getCountMarkUP()
    {
        return GlobalSetting::count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getMarkUP($limit, $start);
        $totalData = $this->getCountMarkUP();
        $totalFiltered = $totalData;


        $global_settings = $getQuery->orderBy('id', 'desc')->get();

        $dataArray = [];
        if (!empty($global_settings)) {
            foreach ($global_settings as $key => $global_settings) {
                $id = $global_settings->id;
                $key = $global_settings->key;
                $markup_price = $global_settings->value;
                $creted_at = date('Y-m-d H:i', strtotime($global_settings->created_at));


                $dataArray[] = [
                    'id' => $id,
                    'key' => $key,
                    'markup_product' => $markup_price,
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
        return GlobalSetting::where('id', $id)->first();
    }
}
