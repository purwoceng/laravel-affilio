<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\RoleRepositoryInterface;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private $role_repository;

    public function __construct(RoleRepositoryInterface $role_repository)
    {
        $this->middleware([
            'role:super_user',
            'permission:read_role|create_role|update_role|delete_role'
        ]);

        $this->role_repository = $role_repository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->role_repository->getDataTable($request);

            return response()->json($data);
        }

        return view('roles.index');
    }
}
