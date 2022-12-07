<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Repositories\Interfaces\User\UserRepositoryInterface;
use Illuminate\Http\Request;

class UserController extends Controller
{
    private $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->middleware([
            'role:super_admin',
            'permission:read_role|create_role|update_role|delete_role'
        ]);

        $this->user_repository = $user_repository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->user_repository->getDataTable($request);

            return response()->json($data);
        }

        return view('users.index');
    }
}
