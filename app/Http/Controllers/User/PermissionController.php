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
}
