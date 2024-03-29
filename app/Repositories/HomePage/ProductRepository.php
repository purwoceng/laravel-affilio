<?php

namespace App\Repositories\HomePage;

use App\Models\ProductHome;
use App\Models\ProductHomeType;
use App\Repositories\Interfaces\HomePage\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function __construct()
    {
        // 
    }

    public function getProductHomeTypes($limit, $start)
    {
        return ProductHomeType::where('type', ['recommendation'])->offset($start)->limit($limit);
    }

    public function getProductHomeTypeById($id)
    {
        return ProductHomeType::where('type', ['recommendation'])->where('id', $id)->first();
    }

    public function getTotalProductHomeTypes()
    {
        return ProductHomeType::where('type', ['recommendation'])->count();
    }

    public function getProductHomeTypeDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $product_home_query = $this->getProductHomeTypes($limit, $start);
        $total_data = $this->getTotalProductHomeTypes();
        $product_home_types = $product_home_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($product_home_types)) {
            foreach ($product_home_types  as $key => $product_home_type) {
                $id = $product_home_type->id;
                $type = $product_home_type->type;
                $name = $product_home_type->name;
                $code = $product_home_type->code;
                $actions = ['id' => $id, 'name' => $name];
                $created_at = date('d/m/Y H:i', strtotime($product_home_type->created_at));

                $data[] = compact(
                    'id',
                    'type',
                    'name',
                    'code',
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

    public function getProductHomes($limit, $start)
    {
        return ProductHome::where('type', ['recommendation'])->offset($start)->limit($limit);
    }

    public function getProductHomeById($id)
    {
        return ProductHome::where('type', ['recommendation'])->where('id', $id)->first();
    }

    public function getTotalProductHomes()
    {
        return ProductHome::where('type', ['recommendation'])->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $product_home_query = $this->getProductHomes($limit, $start);
        $total_data = $this->getTotalProductHomes();
        $product_homes = $product_home_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($product_homes)) {
            foreach ($product_homes  as $key => $product_home) {
                $id = $product_home->id;
                $name = $product_home->name ?? '-';
                $type = $product_home->type;
                $product_id = $product_home->product_id;
                $queue_number = $product_home->queue_number;
                $is_active = $product_home->is_active;
                $actions = $id;
                $created_at = date('d/m/Y H:i', strtotime($product_home->created_at));

                $data[] = compact(
                    'id',
                    'type',
                    'name',
                    'product_id',
                    'queue_number',
                    'is_active',
                    'actions',
                    'created_at',
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
