<?php

namespace App\Repositories\User;

use App\Models\Role;
use App\Repositories\Interfaces\User\RoleRepositoryInterface;

class RoleRepository implements RoleRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getRoles($limit, $start)
    {
        return Role::offset($start)->limit($limit);
    }

    public function getTotalRoles()
    {
        return Role::all()->count();
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $role_query = $this->getRoles($limit, $start);
        $total_data = $this->getTotalRoles();
        $roles = $role_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($roles)) {
            foreach ($roles  as $key => $role) {
                $id = $role->id;
                $name = $role->name;
                $label = $role->label;
                $actions = $id;

                $data[] = compact(
                    'id',
                    'name',
                    'label',
                    'actions',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data,
        ];

        return $result;
    }
}
