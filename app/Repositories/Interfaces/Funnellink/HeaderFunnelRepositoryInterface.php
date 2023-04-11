<?php

namespace App\Repositories\Interfaces\Funnellink;

interface HeaderFunnelRepositoryInterface
{
    public function getHeader($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountHeader();

    public function getDataTable($request);
}
