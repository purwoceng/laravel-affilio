<?php

namespace App\Repositories\Interfaces\Funnellink;

interface PopupRepositoryInterface
{
    public function getPopup($limit, $start);

    public function create(array $data);

    public function update($id, array $data);

    public function delete($id);

    public function getCountPopup();

    public function getDataTable($request);
}