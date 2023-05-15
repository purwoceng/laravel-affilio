<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Repositories\Interfaces\User\UserRepositoryInterface;

class UserController extends Controller
{
    private $user_repository;

    public function __construct(UserRepositoryInterface $user_repository)
    {
        $this->middleware([
            'role:super_user',
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

    public function show($id)
    {
        $selected_user = $this->user_repository->getUserById($id);
        $title = !empty($selected_user->id)
            ? "Pengguna: {$selected_user->name}"
            : 'Pengguna Tidak Ditemukan';
        $data = ['user' => $selected_user, 'title' => $title];

        return view('users.detail', $data);
    }

    public function create()
    {
        $roles = Role::get();
        return view('users.create',compact('roles'));
    }
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'roles' => 'required'
        ]);

        $input = $request->all();
        $input['password'] = Hash::make($input['password']);

        $user = User::create($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function edit($id)
    {
        $data = User::find($id);
        $roles = Role::get();
        return view('users.edit',compact('data','roles'));
    }

    public function update(Request $request, $id)
    {
         $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'roles' => 'required'
        ]);

        $input = $request->except(['_token']);
        $input['password'] = Hash::make($input['password']);

        $user = User::whereIn('id', $id)->update($input);
       //$user = User::find($id)->update($input);
        $user->assignRole($request->input('roles'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }
}
