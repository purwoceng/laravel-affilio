<?php

namespace App\Repositories\Funnellink;

use App\Models\HeaderFunnel;
use App\Repositories\Interfaces\Funnellink\HeaderFunnelRepositoryInterface;

class HeaderFunnelRepository implements HeaderFunnelRepositoryInterface
{
    public function __construct()
    {
        //
    }
    public function create(array $data)
    {
        return HeaderFunnel::create($data);
    }

    public function update($id, array $data)
    {
        return HeaderFunnel::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return HeaderFunnel::where('id', $id)->delete();
    }

    public function getHeaderById($id)
    {
        return HeaderFunnel::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountHeader()
    {
        return HeaderFunnel::all()->count();
    }

    public function getHeader($limit, $start)
    {
        return HeaderFunnel::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $header_query = $this->getHeader($limit, $start);
        $total_data = $this->getCountHeader();

        $headers = $header_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($headers)) {
            foreach ($headers  as $key => $head) {
                $id = $head->id;
                $header = $head->header;
                $description = $head->description ?? '-';
                $is_active = $head->is_active ?? '-';
                $created_at = date('Y-m-d H:i', strtotime($head->created_at));
                // $created_at = date('Y-m-d H:i', strtotime($header->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'header',
                    'description',
                    'is_active',
                    'created_at',
                    // 'created_at',
                    'actions',

                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data,
        ];

        return $result;
    }
}
