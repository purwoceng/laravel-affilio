<?php

namespace App\Http\Controllers\Invoice\Cancel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\Invoice\Cancel\InvoiceCancelRepositoryInterface;

class InvoiceCancelController extends Controller
{
    private $invoiceCancelRepository;

    public function __construct(InvoiceCancelRepositoryInterface $invoiceCancelRepository)
    {
        $this->invoiceCancelRepository = $invoiceCancelRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->invoiceCancelRepository->getDataTable($request);
        }
        return view('invoices.cancel.index');
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
        // $messages = [
        //     'name.required' => 'Nama tidak boleh kosong',
        //     'name.unique' => 'Nama kategori sudah digunakan',

        //     'code.required' => 'Tipe tidak boleh kosong',
        //     'code.unique' => 'Tipe kategori sudah digunakan',
        // ];

        // $validator = Validator::make($request->all(), [
        //     'name' => 'required|max:64',
        //     'code' => 'required|unique:cs_number_categories,code|max:64',
        // ], $messages);

        // if ($validator->fails()) {
        //     return Redirect::back()->withErrors($validator)
        //         ->withInput();
        // }

        // $createData = [
        //     'name' => $request->name,
        //     'code' => $request->code,
        // ];

        // $result = $this->csCategoryRepository->create($createData);

        // if ($result) {
        //     return redirect()->route('cs-number.category.index')
        //         ->with('success', 'Data Kategori Nomor CS telah berhasil dibuat');
        // } else {
        //     return back()->withInput()->with('info', 'Gagal membuat data kategori nomor cs');
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->invoiceCancelRepository->getDataById($id);
        return view('invoices.cancel.show', compact('data'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
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
