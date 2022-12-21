<?php

namespace App\Repositories\Interfaces\content;

interface MarkUpRepositoryInterface
{
    public function getMarkupBlocked($limit, $start);

    public function getCountMarkupBlocked();

    public function getDataTable($request);
}
