<?php

namespace App\Http\Controllers\HomePage;

use Illuminate\Http\Request;
use App\Models\CsNumberCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\Content\CS\CsNumberRepositoryInterface;

class CsNumberController extends Controller
{
    private $csNumberRepository;

    public function __construct(CsNumberRepositoryInterface $csNumberRepository)
    {
        $this->csNumberRepository = $csNumberRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->csNumberRepository->getDataTable($request);
        }
        return view('content.cs_numbers.cs_number.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $csNumberCategories = CsNumberCategory::get();
        return view('content.cs_numbers.cs_number.create',compact(['csNumberCategories']));
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
            'name.required' => 'Nama tidak boleh kosong',
            'name.unique' => 'Nama sudah digunakan',
            'number.required' => 'Nomor Handphone tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cs_numbers|max:64',
            'number' => 'required|numeric',
            'cs_category_id' => 'required',
        ],$messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $number = $request->number;
        $csCategoryId = $request->cs_category_id;

        $createData = [
            'cs_category_id' => $csCategoryId,
            'number' => $number,
            'name' => $name,
        ];


        $result = $this->csNumberRepository->create($createData);

        if ($result) {
            return redirect()->route('cs-number.index')
                ->with('success', 'Data Nomor CS telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data nomor cs');
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
        $csNumberCategories = CsNumberCategory::get();
        $data = $this->csNumberRepository->getDataById($id);

        return view('content.cs_numbers.cs_number.show',compact(['data','csNumberCategories']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $csNumberCategories = CsNumberCategory::get();
        $data = $this->csNumberRepository->getDataById($id);
        return view('content.cs_numbers.cs_number.edit',compact(['data','csNumberCategories']));
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
            'name.required' => 'Nama tidak boleh kosong',
            'name.unique' => 'Nama sudah digunakan',
            'number.required' => 'Nomor Handphone tidak boleh kosong',
            'code.unique' => 'Tipe kategori sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:cs_numbers|max:64',
            'number' => 'required|numeric',
            'cs_category_id' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $number = $request->number;
        $csCategoryId = $request->cs_category_id;

        $updateData = [
            'cs_category_id' => $csCategoryId,
            'number' => $number,
            'name' => $name,
        ];

        $result = $this->csNumberRepository->update($id,$updateData);

        if ($result) {
            return redirect()->route('cs-number.index')
                ->with('success', 'Data Nomor CS telah berhasil diperbaharui');
        } else {
            return back()->withInput()->with('info', 'Gagal memperbaharui data nomor cs');
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
        $delete = $this->csNumberRepository->delete($id);

        if ($delete) {
            return redirect()->route('cs-number.index')
                ->with('success', 'Data Nomor CS telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data nomor cs');
        }
    }
}
