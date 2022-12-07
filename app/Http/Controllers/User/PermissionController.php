<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\PermissionRepositoryInterface;
use Illuminate\Http\Request;

class PermissionController extends Controller
{
    private $permission_repository;

    public function __construct(PermissionRepositoryInterface $permission_repository)
    {
        $this->middleware([
            'role:super_user',
            'permission:read_role|create_role|update_role|delete_role'
        ]);

        $this->permission_repository = $permission_repository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->permission_repository->getDataTable($request);

            return response()->json($data);
        }

        return view('permissions.index');
    }

    public function show($id)
    {
        $selected_permission = $this->permission_repository->getPermissionById($id);
        $title = "Izin Akses: {$selected_permission->name}" ?? 'Izin Akses Tidak Ditemukan';
        $data = ['permission' => $selected_permission, 'title' => $title];

        return view('permissions.detail', $data);
    }
}
