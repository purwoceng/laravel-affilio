<?php

namespace App\Repositories\Interfaces\User;

interface RoleRepositoryInterface
{
    public function getRoles($limit, $start);

    public function getDataTable($request);
}
