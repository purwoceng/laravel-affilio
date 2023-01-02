<?php

namespace App\Http\Controllers\Member;


use App\Models\MemberType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Member\MemberTypeRepository;

class MemberTypeController extends Controller
{
    protected $memberTypeRepository;
    public function __construct(MemberTypeRepository $memberTypeRepository)
    {
        $this->memberTypeRepository = $memberTypeRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->memberTypeRepository->getDataTable($request);
        }
        return view('members.member_type.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $membertype = new MemberType;
        return view('members.member_type.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'type.required' => 'Tipe tidak boleh kosong',
            'type.unique' => 'Tipe Member sudah digunakan',
            'min_omset.numeric' => 'Minimum Omset Harus berupa angka',
        ];

        $validator = Validator::make($request->all(), [
            'type' => 'required|max:64',
            'min_omset' => 'numeric|min:0|max:1000000000000',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $createData = [
            'type' => $request->type,
            'min_omset' => $request->min_omset,
        ];
        $result = $this->memberTypeRepository->create($createData);

        if ($result) {
            return redirect()->route('members.member_type.index')
                ->with('success', 'Data Tipe Member telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data tipe member');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->memberTypeRepository->getDataById($id);
        return view('members.member_type.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->memberTypeRepository->getDataById($id);
        return view('members.member_type.edit', compact(['data']));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $messages = [
            'type.required' => 'Tipe tidak boleh kosong',
            'type.unique' => 'Tipe kategori sudah digunakan',
            'min_omset.numeric' => 'Minimum Omset harus berupa angka',

        ];

        $validator = Validator::make($request->all(), [
            'type' => 'required|max:64',
            'min_omset' => 'numeric|min:0|max:1000000000000',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'type' => $request->type,
            'min_omset' => $request->min_omset,

        ];

        $result = $this->memberTypeRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('members.member_type.index')
                ->with('success', 'Data Kategori Tipe Member telah berhasil diubah.');
        } else {
            return back()->withInput()->with('info', 'Gagal memperbaharui data kategori Tipe Member');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = $this->memberTypeRepository->delete($id);

        if ($delete) {
            return redirect()->route('members.member_type.index')
                ->with('success', 'Data Kategori Tipe Member telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data kategori tipe member');
        }
    }
}
