<?php

namespace App\Repositories\Interfaces\User;

interface PermissionRepositoryInterface
{
    public function getPermissions($limit, $start);

    public function getPermissionById($id);

    public function getDataTable($request);
}
