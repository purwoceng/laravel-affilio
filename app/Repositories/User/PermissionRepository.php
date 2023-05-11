<?php

namespace App\Repositories\User;

use App\Models\Permission;
use App\Repositories\Interfaces\User\PermissionRepositoryInterface;

class PermissionRepository implements PermissionRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function getPermissions($limit, $start)
    {
        return Permission::offset($start)->limit($limit);
    }

    public function getPermissionById($id)
    {
        return Permission::where('id', $id)->first();
    }

    public function getTotalPermissions()
    {
        return Permission::all()->count();
    }

    public function getDataTable($request)
    {
        
        $limit = $request->input('length');
        $start = $request->input('start');

        $permission_query = $this->getPermissions($limit, $start);
        $total_data = $this->getTotalPermissions();
        $permissions = $permission_query->orderBy('id', 'desc')->get();

        $data = [];

        if (!empty($permissions)) {
            foreach ($permissions  as $key => $permission) {
                $id = $permission->id;
                $name = $permission->name;
                $label = $permission->label;
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
