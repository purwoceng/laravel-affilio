<?php

namespace App\Repositories\Supplier;

use App\Repositories\Interfaces\Supplier\SupplierListRepositoryInterface;

class SupplierListRepository implements SupplierListRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        // $supplier_home_query = $this->getSupplierHomes($limit, $start);
        // $total_data = $this->getTotalSupplierHomes();
        // $supplier_homes = $supplier_home_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($supplier_homes)) {
            foreach ($supplier_homes  as $key => $supplier_home) {
                $id = $supplier_home->id;
                $supplier_id = $supplier_home->supplier_id;
                $supplier_home_type_id = $supplier_home->supplier_home_type_id;
                $queue_number = $supplier_home->queue_number;
                $is_active = $supplier_home->is_active;
                $actions = $id;
                $created_at = date('d/m/Y H:i', strtotime($supplier_home->created_at));

                $data[] = compact(
                    'id',
                    'supplier_id',
                    'supplier_home_type_id',
                    'queue_number',
                    'is_active',
                    'created_at',
                    'actions',
                );
            }
        }

        // $result = [
        //     'draw' => intval($request->input('draw')),
        //     'recordsTotal' => intval($total_data),
        //     'recordsFiltered' => intval($total_data),
        //     'data' => $data,
        // ];

        // return $result;
    }
}
