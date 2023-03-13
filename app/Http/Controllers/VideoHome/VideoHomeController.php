<?php

namespace App\Http\Controllers\VideoHome;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\VideoHome\VideoHomeRepository;

class VideoHomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $videoHomeRepository;

    public function __construct(VideoHomeRepository $videoHomeRepository)
    {
        $this->VideoHomeRepository = $videoHomeRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->VideoHomeRepository->getDataTable($request);
        }
        return view('video_home.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video_home.create');
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
        $messages = [
            'header.required' => 'Header tidak boleh kosong',
            'file.required' => 'File tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'header' => 'required|max:255',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $header = $request->header;

        $createData = [
            'header' => $header,
        ];

        $file = $request->file('file');

        if($file) {
            $filename = 'Video-' . time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/videotraining/'), $filename);
            $path_file = 'storage/system_storage/videotraining/' . $filename;
            $createData['file'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/videotraining/') . $filename));

        }

        $result = $this->VideoHomeRepository->create($createData);


        if ($result) {
            return redirect()->route('video_home.index')
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
        $data = $this->VideoHomeRepository->getVideoHomeById($id);
        return view('video_home.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->VideoHomeRepository->getVideoHomeById($id);
        return view('video_home.edit', compact(['data']));
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
            'header.required' => 'Header tidak boleh kosong',
            'file.required' => 'File tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'header' => 'required|max:255',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $header = $request->header;

        $updateData = [
            'header' => $header,
        ];

        $file = $request->file('file');

        if($file) {
            $filename = 'Video-' . time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/videohome/'), $filename);
            $path_file = 'storage/system_storage/videohome/' . $filename;
            $updateData['file'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/videohome/') . $filename));

        }

        $result = $this->VideoHomeRepository->update($id,$updateData);


        if ($result) {
            return redirect()->route('video_home.index')
                ->with('success', 'Data Video Home Fitur Panel telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data Video Home Fitur Panel');
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
        $delete = $this->VideoHomeRepository->delete($id);

        if ($delete) {
            return redirect()->route('video_home.index')
                ->with('success', 'Data Video Home Fitur Panel telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data kategori Video Home Fitur Panel');
        }
    }
}
