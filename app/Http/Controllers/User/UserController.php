<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $permission = Permission::get();
        return view('users.create',compact('roles','permission'));
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
        $user->syncPermissions($request->input('permission'));

        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function edit($id)
    {
        $data = User::with('permissions')->find($id);
        $roles = Role::get();
        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
        ->all();
        return view('users.edit',compact('data','roles','permission'));
    }

    public function update(Request $request, $id)
    {
        $validation_messages = [
            'name.required' => 'Nama member wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email tidak tersedia atau telah dipakai oleh member lain',
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username tidak tersedia atau telah dipakai oleh member lain',
        ];

        $this->validate($request, [
            'name' => 'required',
            'username' => 'required',
            'email' => 'required',
        ],
        $validation_messages,
    );

        $user = User::findOrFail($id);
        $user->name = $request->name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->syncPermissions($request->input('permission'));
        $user->save();
        return redirect()->route('users.index')
                        ->with('success','User created successfully');
    }

    public function destroy($id)
    {
        $role = User::findOrFail($id);
        $role->delete();
        return redirect()->back()->with(['success' => 'User: <strong>' . $role->name . '</strong> Dihapus']);


    }

    public function editpassword($id)
    {
        $data = User::find($id);
        return view ('users.editpassword',compact('data'));
    }

    public function updatepassword(Request $request, $id)
    {
        $this->validate($request, [
            'password' => 'required',
        ]);

        $user = User::findOrFail($id);
        $user['password'] = Hash::make($request['password']);
        $user->save();
        return redirect()->route('users.index')
                        ->with('success','Password User updated successfully');
    }
}
