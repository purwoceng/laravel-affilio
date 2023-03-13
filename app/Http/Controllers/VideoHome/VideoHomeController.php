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
        ];

        $validator = Validator::make($request->all(), [
             'header' => 'required|max:100',
            'file'   => 'required|sometimes|mimes:3gp,mp4,mov,ogg | max:2000000',
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
            $filename = 'Tipe_' . time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/videohome/'), $filename);
            $path_file = 'storage/system_storage/videohome/' . $filename;
            $createData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/videohome/') . $filename));

        }

        $result = $this->VideoHomeRepository->create($createData);


        if ($result) {
            return redirect()->route('video_home.index')
                ->with('success', 'Data video home fitur panel telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data video home fitur panel');
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
        //
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
