<?php

namespace App\Repositories\Supplier;

use App\Models\SupplierNonActive;
use App\Repositories\Interfaces\Supplier\SupplierNonActiveRepositoryInterface;

class SupplierNonActiveRepository implements SupplierNonActiveRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return SupplierNonActive::create($data);
    }

    public function delete($id)
    {
        return SupplierNonActive::where('id', $id)->forceDelete();
    }

    public function getData($limit, $start)
    {
        return SupplierNonActive::offset($start)->limit($limit);
    }

    public function getTotalData()
    {
        return SupplierNonActive::count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getData($limit, $start);
        $total_data = $this->getTotalData();
        $supplierNonActives = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($supplierNonActives)) {
            foreach ($supplierNonActives  as $key => $supplier) {
                $id = $supplier->id;
                $origin_supplier_id = $supplier->origin_supplier_id;
                $username = $supplier->username;
                $image_url = $supplier->image_url;
                $store_name = $supplier->store_name;
                $created_at = date('d/m/Y H:i', strtotime($supplier->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'origin_supplier_id',
                    'image_url',
                    'username',
                    'store_name',
                    'created_at',
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
