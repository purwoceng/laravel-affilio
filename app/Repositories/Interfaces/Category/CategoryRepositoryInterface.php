<?php

namespace App\Repositories\Interfaces\Category;

interface CategoryRepositoryInterface
{
    public function getCategories($limit, $start);

    public function getTotalCategory();

    public function getDataTable($request);
}
