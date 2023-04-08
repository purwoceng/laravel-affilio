<?php

namespace App\Http\Controllers\HomePage;

use App\Models\FunnelLink;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
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
            'type.required' => 'Tipe Funneling tidak boleh kosong',
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
            'is_active' => '1',
        ];

        $image = $request->file('image');

        if($image) {
            $filename = 'Image-' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/funnelhome/thumbnail/'), $filename);
            $path_file = 'storage/system_storage/funnelhome/thumbnail/' . $filename;
            $createData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/funnelhome/thumbnail/') . $filename));

        }

        $result = $this->funnellinkRepository->create($createData);

        if ($result){
            return redirect()->route('funnel.index')->with('success', 'Data Funneling Home Berhasil Dibuat');
        }else{
            return back()->withInput()->with('Info', 'Gagal membuat data Funneling Home');
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
            'type.required' => 'Tipe Funneling tidak boleh kosong',
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
            'is_active' => $request->is_active,
        ];

        $image = $request->file('image');

        if($image) {

            $filename = 'Image-' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/funnelhome/thumbnail/'), $filename);
            $path_file = 'storage/system_storage/funnelhome/thumbnail/' . $filename;
            $updateData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/funnelhome/thumbnail/') . $filename));

        }

        $result = $this->funnellinkRepository->update($id,$updateData);

        if ($result){
            return redirect()->route('funnel.index')->with('success', 'Data Funneling Home Berhasil Diubah');
        }else{
            return back()->withInput()->with('Info', 'Gagal mengubah Funneling Home link');
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
            return redirect()->route('funnel.index')->with('success', 'Data Funneling Home Berhasil Dihapus.');
        }else{
            return back()->withInput()->with('Info', 'Gagal menghapus data Funneling Home');
        }
    }
}
