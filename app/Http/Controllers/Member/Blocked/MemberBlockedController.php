<?php

namespace App\Http\Controllers\Member\Blocked;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\MemberType;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\Member\Blocked\MemberBlockedRepositoryInterface;

class MemberBlockedController extends Controller
{
    private $memberBlockedRepository;

    public function __construct(MemberBlockedRepositoryInterface $memberBlockedRepository)
    {
        $this->memberBlockedRepository = $memberBlockedRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $member_type = MemberType::get();
        if ($request->ajax()) {
            return $this->memberBlockedRepository->getDataTable($request);
        }

        return view('members.blocked.index', compact('member_type'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Member::findOrFail($id);
        return view('members.blocked.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->memberBlockedRepository->getDataById($id);
        $member_types = MemberType::get();
        return view('members.blocked.edit', compact(['data'],['member_types']));
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
            'name.required' => 'Nama member wajib diisi!',
            'email.required' => 'Email wajib diisi!',
            'email.email' => 'Email tidak valid!',
            'email.unique' => 'Email tidak tersedia atau telah dipakai oleh member lain',
            'username.required' => 'Username wajib diisi!',
            'username.unique' => 'Username tidak tersedia atau telah dipakai oleh member lain',
            'phone.required' => 'Nomor Telepon / HP tidak valid!',
            'phone.regex' => 'Nomor telepon / HP harus diisi dengan nomor telepon indonesia',
            'member_type_id.required' => 'Tipe member wajib diisi!',
            'member_type_id.exists' => 'Tipe member tidak valid. Muat ulang halaman!',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'phone' => 'required|min:10|max:13',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone' => $request->phone,
            'member_type_id' => $request->member_type_id,

        ];

        $result = $this->memberBlockedRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('members.blocked.index')
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
        //
    }
}
