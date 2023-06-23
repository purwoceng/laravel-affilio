<?php

namespace App\Http\Controllers\User;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\Validation\Validator;
use App\Repositories\Interfaces\User\RoleRepositoryInterface;

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

    public function show($id)
    {
        $selected_role = $this->role_repository->getRoleById($id);
        $title = !empty($selected_role->id)
            ? "Peran: {$selected_role->name}"
            :'Peran Tidak Ditemukan';
        $data = ['role' => $selected_role, 'title' => $title];

        return view('roles.detail', $data);
    }

    public function create()
    {
        return view ('roles.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'name.required' => 'Judul Video tidak boleh kosong',
            'label.required' => 'url video tidak boleh kosong',
        ];

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:100',

        // ], $messages);

        // if($validator->fails()){
        //     return Redirect::back()->withErrors($validator)->withInput();
        // }

        $createData = [
            'name' => $request->name,
            'label' => $request->label,
            'guard_name' => 'web',
        ];


        $result = $this->role_repository->create($createData);

        if ($result) {
            return redirect()->route('roles.index')
                ->with('success', 'Data Role User telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data role user');
        }
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->back()->with(['success' => 'User:  $role->name  Dihapus']);


    }

}
