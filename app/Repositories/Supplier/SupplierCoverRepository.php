<?php

namespace App\Repositories\Supplier;

use App\Models\SupplierCover;
use App\Repositories\Interfaces\Supplier\SupplierCoverRepositoryInterface;

class SupplierCoverRepository implements SupplierCoverRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return SupplierCover::create($data);
    }
    public function update($id,array $data)
    {
        return SupplierCover::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return SupplierCover::where('id', $id)->forceDelete();
    }

    public function getSupplierCover($limit, $start)
    {
        return SupplierCover::offset($start)->limit($limit);
    }

    public function getCountSupplierCover()
    {
        return SupplierCover::count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getSupplierCover($limit, $start);
        $total_data = $this->getCountSupplierCover();
        $supplierCover = $getQuery->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($supplierCover)) {
            foreach ($supplierCover  as $key => $supplier) {
                $id = $supplier->id;
                $image = $supplier->image? config('app.s3_url') . $supplier->image : '';
                $is_active = $supplier->is_active;
                $created_at = date('d/m/Y H:i', strtotime($supplier->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'image',
                    'is_active',
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
