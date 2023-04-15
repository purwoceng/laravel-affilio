<?php

namespace App\Http\Controllers\HomePage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\HeaderFunnel;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Funnellink\HeaderFunnelRepository;

class HeaderFunnelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    protected $headerfunnelRepository;

    public function __construct(HeaderFunnelRepository $headerFunnelRepository)
    {
        $this->headerfunnelRepository = $headerFunnelRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->headerfunnelRepository->getDataTable($request);
        }
        return view('content.headerfunnel.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.headerfunnel.create');
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
            'header.required' => 'Header tidak boleh kosong',
            'description.required' => 'Deskripsi tidak boleh kosong',
            'is_active.required' => 'Status tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'header' => 'required',
            'description' => 'required',
            'is_active' => 'required'
        ], $messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $header = $request->header;
        $description = $request->description;
        $is_active = $request->is_active;

        $createData = [
            'header' => $header,
            'description' => $description,
            'is_active' => $is_active,
        ];

        $result = $this->headerfunnelRepository->create($createData);
        if ($result) {
            return redirect()->route('headerfunnel.index')
                ->with('success', 'Header Funnel telah berhasill dibuat');
        } else {
            return back()->withInput() - with('info', 'Gagal membuat data Header Funnel');
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
        $data = HeaderFunnel::findorfail($id);
        return view('content.headerfunnel.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = HeaderFunnel::findorfail($id);
        return view('content.headerfunnel.edit', compact('data'));
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
            'header.required' => 'Header Funnel tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'header' => $request->header,
            'description' => $request->description,
            'is_active' => $request->is_active,
        ];



        $result = $this->headerfunnelRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('headerfunnel.index')->with('success', 'Data Header Funnel Berhasil Diubah');
        } else {
            return back()->withInput()->with('Info', 'Gagal mengubah Header Funnel link');
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
        $delete = $this->headerfunnelRepository->delete($id);
        if ($delete) {
            return redirect()->route('headerfunnel.index')->with('success', 'Data Header Funnel Berhasil Dihapus.');
        } else {
            return back()->withInput()->with('Info', 'Gagal menghapus data Header Funnel');
        }
    }
}
