<?php

namespace App\Repositories\ProductInactive;

use App\Models\ProductInactive;
use App\Repositories\Interfaces\ProductInactive\ProductInactiveRepositoryInterface;

class ProductInactiveRepository implements ProductInactiveRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getInactiveProducts($limit, $start)
    {
        return ProductInactive::limit($limit)->offset($start);
    }

    public function getTotalInactiveProducts()
    {
        return ProductInactive::all()->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $query = $this->getInactiveProducts($limit, $start);
        $totalData = $this->getTotalInactiveProducts();
        $data = [];

        // if ($request->filled('name')) {
        //     $keyword = $request->get('name');
        //     $query->where('name', 'like', '%' . $keyword . '%');
        //     $totalData = $query->count();
        // }

        $inactiveProducts = $query->orderBy('id', 'desc')->get();
        $totalFilteredData = $totalData;

        if (!empty($inactiveProducts)) {
            foreach ($inactiveProducts as $key => $inactiveProduct) {
                $id = $inactiveProduct->id;
                $name = $inactiveProduct->name;
                $image_url = $inactiveProduct->image_url;
                $origin_product_id = $inactiveProduct->origin_product_id;
                $actions = ['id' => $id, 'name' => $name];
                $created_at = date('d/m/Y H:i', strtotime($inactiveProduct->created_at));
                $updated_at = date('d/m/Y H:i', strtotime($inactiveProduct->updated_at));

                $data[] = compact(
                    'id',
                    'origin_product_id',
                    'name',
                    'image_url',
                    'created_at',
                    'updated_at',
                    'actions',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFilteredData),
            'data' => $data,
        ];

        return $result;
    }

    public function removeInactiveProduct($id)
    {
        $product = ProductInactive::findOrFail($id);
        return $product->delete();
    }
}
