<?php

namespace App\Repositories\Interfaces\User;

interface RoleRepositoryInterface
{
    public function getRoles($limit, $start);

    public function getRoleById($id);

    public function getDataTable($request);

    public function create(array $data);
}
