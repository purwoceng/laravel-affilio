<?php

namespace App\Repositories\Interfaces\Funnellink;

interface FunnelLinkRepositoryInterface
{
    public function getLink($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountLink();

    public function getDataTable($request);
}
