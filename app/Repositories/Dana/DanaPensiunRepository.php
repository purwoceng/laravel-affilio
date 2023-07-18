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

    public function getCountDanaPensiun($startDate, $endDate)
    {
        return DanaPensiun::whereBetween('code', ['bpsb', 'bpsd'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->get()->count();
    }
    public function getDataById($id)
    {
        return DanaPensiun::whereBetween('code', ['bpsb', 'bpsd'])->where('id', $id)->first();
    }

    public function getDanaPensiun($limit, $start, $startDate, $endDate)
    {
        return DanaPensiun::whereBetween('code', ['bpsb', 'bpsd'])->whereDate('created_at', '>=', $startDate)->whereDate('created_at', '<=', $endDate)->offset($start)->limit($limit);
    }


    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        if (!empty($request->date_range)) {
            $dateRange = $request->date_range;
            $date = explode("/", $dateRange);;
            $startDate = $date[0];
            $endDate = $date[1];
        } else {
            $now = date('Y-m-d');
            $startDate = $now;
            $endDate = $now;
        }

        $pensiun_query = $this->getDanaPensiun($limit, $start, $startDate, $endDate);
        $totalData = $this->getCountDanaPensiun($startDate, $endDate);
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
            'recordsFiltered' => intval($totalData),
            'data' => $data,
        ];

        return $result;
    }
}
