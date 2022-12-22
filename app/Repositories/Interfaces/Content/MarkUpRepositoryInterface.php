<?php

namespace App\Repositories\Interfaces\content;

interface MarkUpRepositoryInterface
{
    public function getMarkup($limit, $start);

    public function getDataTable($request);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getDataById($id);
}
