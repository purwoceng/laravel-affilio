<?php

namespace App\Http\Controllers\Dana;

use App\Http\Controllers\Controller;
use App\Repositories\Dana\DanaPensiunRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class DanaPensiunController extends Controller
{
    private $danapensiunRepository;

    public function __construct(DanaPensiunRepository $danaPensiunRepository)
    {
        $this->danapensiunRepository = $danaPensiunRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->danapensiunRepository->getDataTable($request);
        }

        return view('danas.pensiun.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('danas.pensiun.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // exit;

        $validation_massages = [
            'username.required' => 'Judul Tidak Boleh Kosong',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'username' => 'required|max:64',
                'value' => 'required',
                'title' => 'required',
            ],
            $validation_massages
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $username = $request->username;
        $value = $request->value ?? '';
        $pensiun = $request->pensiun ?? '';
        $title = $request->title ?? '';

        $createData = [
            'username' => $username,
            'value' => $value,
            'pensiun' => $pensiun,
            'title' => $title,
        ];

        $result = $this->danapensiunRepository->create($createData);

        if ($result) {
            return redirect()->route('danas.pensiun.index')
                ->with('success', 'Data dana pensiun berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data');
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
        $data = $this->danapensiunRepository->getDataById($id);
        return view('danas.pensiun.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->danapensiunRepository->getDataById($id);
        return view('danas.pensiun.edit', compact([
            'data'
        ]));
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
            'username.required' => 'Nama tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'username' => 'required|max:64',
            'value' => 'required',
            'title' => 'required',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $username = $request->username;
        $value = $request->value ?? '';
        $title = $request->title ?? '';

        $updateData = [

            'username' => $username,
            'value' => $value,
            'title' => $title,
        ];

        $result = $this->danapensiunRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('danas.pensiun.edit', $id)
                ->with('success', 'Data Dana Pensiun telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data event');
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
        $delete = $this->danapensiunRepository->delete($id);

        if ($delete) {
            return redirect()->route('danas.pensiun.index')
                ->with('success', 'Data Dana Pensiun telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data event');
        }
    }
}
