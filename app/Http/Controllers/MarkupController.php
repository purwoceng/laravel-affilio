<?php

namespace App\Http\Controllers;

use App\Models\markup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\content\MarkUpRepository;

class MarkupController extends Controller
{
    protected $MarkupRepository;

    public function __construct(MarkUpRepository $MarkupRepository)
    {
        $this->MarkupRepository = $MarkupRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->MarkupRepository->getDataTable($request);
        }

        return view('content.markup.index');
    }
    public function create()
    {
        $markup = new markup;
        return view('content.markup.create');
    }

    public function store(Request $request)
    {
        $messages = [
            'markup.required' => 'Tipe tidak boleh kosong',
            'markup.unique' => 'Tipe kategori sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'markup' => 'required|numeric|min:10|max:1000',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $createData = [
            'markup' => $request->markup,
        ];

        $result = $this->MarkupRepository->create($createData);

        if ($result) {
            return redirect()->route('markup.index')
                ->with('success', 'Data Markup telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data markup');
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
        $markup = markup::get();
        $data = $this->MarkupRepository->getDataById($id);

        return view('content.markup.show', compact(['data', 'markup']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $markup = markup::get();
        $data = $this->MarkupRepository->getDataById($id);
        return view('content.markup.edit', compact(['data', 'markup']));
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
        // dd();
        // exit;

        $messages = [
            'markup.required' => 'Markup tidak boleh kosong',
            'markup.unique' => 'Markup sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'markup' => 'required | max:64',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $markup = $request->markup;

        $updateData = [
            'markup' => $markup,
        ];

        $result = $this->MarkupRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('markup.edit', $id)
                ->with('success', 'Data Markup telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data markup');
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
        $delete = $this->MarkupRepository->delete($id);

        if ($delete) {
            return redirect()->route('markup.index')
                ->with('success', 'Data Markup telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data markup');
        }
    }
}
