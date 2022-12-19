<?php

namespace App\Repositories\HomePage;

use App\Models\SupplierHome;
use App\Repositories\Interfaces\HomePage\SupplierRepositoryInterface;

class SupplierRepository implements SupplierRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getSupplierHomes($limit, $start)
    {
        return SupplierHome::offset($start)->limit($limit);
    }

    public function getSupplierHomeById($id)
    {
        return SupplierHome::where('id', $id)->first();
    }

    public function getTotalSupplierHomes()
    {
        return SupplierHome::all()->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $supplier_home_query = $this->getSupplierHomes($limit, $start);
        $total_data = $this->getTotalSupplierHomes();
        $supplier_homes = $supplier_home_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($supplier_homes)) {
            foreach ($supplier_homes  as $key => $supplier_home) {
                $id = $supplier_home->id;
                $supplier_id = $supplier_home->supplier_id;
                $supplier_home_type_id = $supplier_home->supplier_home_type_id;
                $queue_number = $supplier_home->queue_number;
                $is_active = $supplier_home->is_active;
                $actions = $id;

                $data[] = compact(
                    'id',
                    'supplier_id',
                    'supplier_home_type_id',
                    'queue_number',
                    'is_active',
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
