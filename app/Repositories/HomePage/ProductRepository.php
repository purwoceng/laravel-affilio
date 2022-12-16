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
        return ProductHomeType::offset($start)->limit($limit);
    }

    public function getProductHomeTypeById($id)
    {
        return ProductHomeType::where('id', $id)->first();
    }

    public function getTotalProductHomeTypes()
    {
        return ProductHomeType::all()->count();
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
                $name = $product_home_type->name;
                $code = $product_home_type->code;
                $actions = ['id' => $id, 'name' => $name];
                $data[] = compact(
                    'id',
                    'name',
                    'code',
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
        return ProductHome::offset($start)->limit($limit);
    }

    public function getProductHomeById($id)
    {
        return ProductHome::where('id', $id)->first();
    }

    public function getTotalProductHomes()
    {
        return ProductHome::all()->count();
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
                $product_id = $product_home->product_id;
                $product_home_type_id = $product_home->product_home_type_id;
                $queue_number = $product_home->queue_number;
                $is_active = $product_home->is_active;
                $actions = $id;

                $data[] = compact(
                    'id',
                    'product_id',
                    'product_home_type_id',
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
