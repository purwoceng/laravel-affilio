<?php

namespace App\Repositories\Dana;

use App\Models\DanaPensiun;
use App\Repositories\Interfaces\Dana\DanaPensiunRepositoryInterface;

class DanaPensiunRepository implements DanaPensiunRepositoryInterface
{
    public function __construct()
    {
        //
    }
    public function create($data)
    {
        return DanaPensiun::create($data);
    }

    public function update($id, array $data)
    {
        return DanaPensiun::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return DanaPensiun::where('id', $id)->forcedelete();
    }

    public function getDataById($id)
    {
        return DanaPensiun::where('id', $id)->first();
    }

    public function getData($limit, $start)
    {
        return DanaPensiun::whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return DanaPensiun::whereNull('deleted_at')->count();
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
            foreach ($getResults as $key => $pensiun) {
                $id = $pensiun->id;
                $username = $pensiun->username;
                $value = $pensiun->value;
                $title = $pensiun->title;
                $created_at = date('d/m/Y H:i', strtotime($pensiun->created_at));

                $data[] = compact(
                    'id',
                    'username',
                    'value',
                    'title',
                    'created_at',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return response()->json($result);
    }
}
