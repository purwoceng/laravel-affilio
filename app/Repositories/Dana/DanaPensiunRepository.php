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

    public function getCountDanaPensiun()
    {
        return DanaPensiun::all()->count();
    }
    public function getDataById($id)
    {
        return DanaPensiun::where('id', $id)->first();
    }

    public function getDanaPensiun($limit, $start)
    {
        return DanaPensiun::offset($start)->limit($limit);
    }


    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $pensiun_query = $this->getDanaPensiun($limit, $start);
        $totalData = $this->getCountDanaPensiun();
        $totalFiltered = $totalData;

        if ($request->filled('username')) {
            $keyword = $request->get('username');
            $pensiun_query->where('username', 'like', '%' . $keyword . '%');
            $totalData = $pensiun_query->count();
            $totalFiltered = $totalData;
        }
        if ($request->filled('code')) {
            $keyword = $request->get('code');
            $pensiun_query->where('code', 'like', '%' . $keyword . '%');
            $totalData = $pensiun_query->count();
            $totalFiltered = $totalData;
        }
        if ($request->filled('description')) {
            $keyword = $request->get('description');
            $pensiun_query->where('description', 'like', '%' . $keyword . '%');
            $totalData = $pensiun_query->count();
            $totalFiltered = $totalData;
        }

        $pensiuns = $pensiun_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($pensiuns)) {
            foreach ($pensiuns as $key => $pensiun) {
                $id = $pensiun->id;
                $username = $pensiun->username;
                $code = $pensiun->code;
                $title = $pensiun->title ?? '-';
                $description = $pensiun->description ?? '-';
                $value = $pensiun->value;
                $status_verify = $pensiun->status_verify ?? '-';
                $created_at = date('d/m/Y H:i', strtotime($pensiun->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'username',
                    'code',
                    'title',
                    'description',
                    'value',
                    'status_verify',
                    'created_at',
                    'actions',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
        ];

        return $result;
    }
}
