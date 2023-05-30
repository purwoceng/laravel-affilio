<?php

namespace App\Repositories\Products;

use App\Models\ProductAffilio;
use App\Repositories\interfaces\Products\ProductAffilioRepositoryInterface;

class ProductAffilioRepository implements ProductAffilioRepositoryInterface

{
    public function __construct()
    {
        //
    }

    public function getProductAffilioTypes($limit, $start)
    {
        return ProductAffilio::where('type', ['affilio_recommendation'])->offset($start)->limit($limit);
    }

    public function getProductAffilioTypeById($id)
    {
        return ProductAffilio::where('type', ['affilio_recommendation'])->where('id', $id)->first();
    }

    public function getTotalProductAffilioTypes()
    {
        return ProductAffilio::where('type', ['affilio_recommendation'])->count();
    }

    public function getProductAffilioTypeDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $product_affilio_query = $this->getProductAffilioTypes($limit, $start);
        $total_data = $this->getTotalProductAffilioTypes();
        $product_affilio_types = $product_affilio_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($product_affilio_types)) {
            foreach ($product_affilio_types  as $key => $product_affilio_type) {
                $id = $product_affilio_type->id;
                $type = $product_affilio_type->type;
                $name = $product_affilio_type->name;
                $code = $product_affilio_type->code;
                $actions = ['id' => $id, 'name' => $name];
                $created_at = date('d/m/Y H:i', strtotime($product_affilio_type->created_at));

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

    public function getProductAffilio($limit, $start)
    {
        return ProductAffilio::where('type', ['affilio_recommendation'])->offset($start)->limit($limit);
    }

    public function getProductAffilioById($id)
    {
        return ProductAffilio::where('type', ['affilio_recommendation'])->where('id', $id)->first();
    }

    public function getTotalProductAffilio()
    {
        return ProductAffilio::where('type', ['affilio_recommendation'])->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $product_affilio_query = $this->getProductaffilio($limit, $start);
        $total_data = $this->getTotalProductaffilio();
        $product_affilios = $product_affilio_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($product_affilios)) {
            foreach ($product_affilios  as $key => $product_affilio) {
                $id = $product_affilio->id;
                $type = $product_affilio->type;
                $product_id = $product_affilio->product_id;
                $queue_number = $product_affilio->queue_number;
                $is_active = $product_affilio->is_active;
                $actions = $id;
                $created_at = date('d/m/Y H:i', strtotime($product_affilio->created_at));

                $data[] = compact(
                    'id',
                    'type',
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
