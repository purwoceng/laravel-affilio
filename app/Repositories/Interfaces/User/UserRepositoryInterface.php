<?php

namespace App\Repositories\Interfaces\User;

interface UserRepositoryInterface
{
    public function getUsers($limit, $start);

    public function getDataTable($request);
}
