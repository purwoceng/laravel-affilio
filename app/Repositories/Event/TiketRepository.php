<?php

namespace App\Repositories\Event;

use App\Models\Tiket;
use App\Repositories\Interfaces\Event\TiketRepositoryInterface;

class TiketRepository implements TiketRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create($data)
    {
        return Tiket::create($data);
    }

    public function update($id, array $data)
    {
        return Tiket::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Tiket::where('id', $id)->forcedelete();
    }

    public function getDataById($id)
    {
        return Tiket::where('id', $id)->first();
    }

    public function getData($limit, $start)
    {
        return Tiket::whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return Tiket::whereNull('deleted_at')->count();
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
            foreach ($getResults as $key => $tiket) {
                $id = $tiket->id;
                $name = $tiket->name;
                $kuota = $tiket->kuota;
                $price = $tiket->price;
                $start = date('d/m/Y H:i', strtotime($tiket->start));
                $finish = date('d/m/Y H:i', strtotime($tiket->finish));
                $created_at = date('d/m/Y H:i', strtotime($tiket->created_at));

                $data[] = compact(
                    'id',
                    'name',
                    'kuota',
                    'price',
                    'start',
                    'finish',
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
