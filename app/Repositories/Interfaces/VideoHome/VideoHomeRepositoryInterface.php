<?php

namespace App\Repositories\Interfaces\VideoHome;

interface VideoHomeRepositoryInterface
{
    public function getVideoHome($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountVideoHome();

    public function getDataTable($request);
}
