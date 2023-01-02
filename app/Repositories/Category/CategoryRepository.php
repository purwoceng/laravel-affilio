<?php

namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\Interfaces\Category\CategoryRepositoryInterface;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function __construct()
    {
        // 
    }
    
    public function getCategories($limit, $start)
    {
        return Category::whereNull('deleted_at')->offset($start)->limit($limit);
    }

    public function getTotalCategory()
    {
        return Category::whereNull('deleted_at')->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $category_query = $this->getCategories($limit, $start);
        $total_data = $this->getTotalCategory();
        $categories = $category_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($categories)) {
            foreach ($categories  as $key => $category) {
                $name = $category['name'];
                $link = $category['link'];          
                $id = $category['id'];
                $origin_category_id = $category['origin_category_id'];
                $description = $category['description'];
                $image = $category['image'];
                $level = $category['level'];
                $created_at = $category['created_at'];

                $data[] = [
                    'name' => $name,
                    'link' => $link,
                    'id' => $id,
                    'origin_category_id' => $origin_category_id,
                    'description' => $description,
                    'image' => $image,
                    'level' => $level,
                    'created_at' => date('d-m-Y H:i', strtotime($created_at)),
                ];
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
