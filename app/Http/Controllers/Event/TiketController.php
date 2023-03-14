<?php

namespace App\Http\Controllers\event;

use App\Http\Controllers\Controller;
use App\Repositories\Event\TiketRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class TiketController extends Controller
{
    private $tiketRepository;

    public function __construct(TiketRepository $tiketRepository)
    {
        $this->tiketRepository = $tiketRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->tiketRepository->getDataTable($request);
        }

        return view('tikets.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tikets.create');
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
            'name.required' => 'Judul Tidak Boleh Kosong',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:64',
                'kuota' => 'required',
                'price' => 'required',
                'start' => 'required',
                'finish' => 'required',
            ],
            $validation_massages
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $kuota = $request->kuota ?? '';
        $price = $request->price ?? '';
        $price = $request->price ?? '';
        $start = $request->start ?? '';
        $finish = $request->finish;

        $createData = [
            'name' => $name,
            'kuota' => $kuota,
            'price' => $price,
            'price' => $price,
            'start' => $start,
            'finish' => $finish,
        ];



        $result = $this->tiketRepository->create($createData);

        if ($result) {
            return redirect()->route('tiket.index')
                ->with('success', 'Data event berhasil dibuat');
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
        $data = $this->tiketRepository->getDataById($id);
        return view('tikets.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->tiketRepository->getDataById($id);
        return view('tikets.edit', compact([
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
            'name.required' => 'Nama tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'kuota' => 'required',
            'price' => 'required',
            'start' => 'required',
            'finish' => 'required',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $kuota = $request->kuota ?? '';
        $price = $request->price ?? '';
        $start = $request->start ?? '';
        $finish = $request->finish ?? '';

        $updateData = [

            'name' => $name,
            'kuota' => $kuota,
            'price' => $price,
            'start' => $start,
            'finish' => $finish,
        ];


        $result = $this->tiketRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('tiket.edit', $id)
                ->with('success', 'Data Tiket telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data tiket');
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
        $delete = $this->tiketRepository->delete($id);

        if ($delete) {
            return redirect()->route('tiket.index')
                ->with('success', 'Data Tiket telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data tiket');
        }
    }
}
