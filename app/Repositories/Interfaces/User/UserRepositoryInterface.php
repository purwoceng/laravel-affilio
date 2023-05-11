<?php

namespace App\Repositories\Interfaces\User;

interface UserRepositoryInterface
{
    public function getUsers($limit, $start);

    public function getUserById($id);

    public function getDataTable($request);
}
