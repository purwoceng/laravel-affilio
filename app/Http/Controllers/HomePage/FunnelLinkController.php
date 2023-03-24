<?php

namespace App\Http\Controllers\HomePage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\FunnelLink;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Funnellink\FunnelLinkRepository;

class FunnelLinkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     protected $funnellinkRepository;

     public function __construct(FunnelLinkRepository $funnelLinkRepository)
     {
        $this->funnellinkRepository = $funnelLinkRepository;
     }
    public function index(Request $request)
    {
        if ($request->ajax()){
            return $this->funnellinkRepository->getDataTable($request);
        }
        return view ('content.funnellink.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('content.funnellink.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url_regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        $messages = [
            'type.required' => 'Tipe Panel Link tidak boleh kosong',
            'url.regex' => 'Kolom URL video harus diisi dengan link (http / https)',
        ];

        $validator = Validator::make($request->all(),[
            'file' => [
                "regex:{$url_regex}",
                'string',
            ],

        ], $messages);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $createData = [
            'type' => $request->type,
            'url' => $request->url,
            'description' => $request->description,
        ];

        $result = $this->funnellinkRepository->create($createData);

        if ($result){
            return redirect()->route('funnel.index')->with('success', 'Data Panel Link Berhasil Dibuat');
        }else{
            return back()->withInput()->with('Info', 'Gagal membuat data Panel link');
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
        $data = FunnelLink::findorfail($id);
        return view('content.funnellink.detail',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = FunnelLink::findorfail($id);
        return view('content.funnellink.edit',compact('data'));
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
            'type.required' => 'Tipe Panel Link tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(),[

        ], $messages);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'type' => $request->type,
            'url' => $request->url,
            'description' => $request->description,
        ];

        $result = $this->funnellinkRepository->update($id,$updateData);

        if ($result){
            return redirect()->route('funnel.index')->with('success', 'Data Panel Link Berhasil Diubah');
        }else{
            return back()->withInput()->with('Info', 'Gagal mengubah data Panel link');
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
        $delete = $this->funnellinkRepository->delete($id);
        if($delete){
            return redirect()->route('funnel.index')->with('success', 'Data Panel Link Berhasil Dihapus.');
        }else{
            return back()->withInput()->with('Info', 'Gagal menghapus data Panel link');
        }
    }
}
