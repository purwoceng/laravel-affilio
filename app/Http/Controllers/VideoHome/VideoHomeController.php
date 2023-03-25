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
        $url_regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        $messages = [
            'header.required' => 'Header tidak boleh kosong',
            'file.required' => 'Url Video tidak boleh kosong',
            'file.string' => 'Url video harus berupa string!',
            'file.regex' => 'Kolom URL video harus diisi dengan link (http / https)',
        ];

        $validator = Validator::make($request->all(), [
            'header' => 'required|max:255',
            'file' => [
                "regex:{$url_regex}",
                'required',
                'string',
            ],

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $header = $request->header;
        $file = $request->file;

        $createData = [
            'header' => $header,
            'file' => $file,
        ];


        $result = $this->VideoHomeRepository->create($createData);


        if ($result) {
            return redirect()->route('video_home.index')
                ->with('success', 'Video Home Default Panel telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat video Home Default Home');
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
        $url_regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        $messages = [
            'header.required' => 'Header tidak boleh kosong',
            'file.required' => 'Url Video tidak boleh kosong',
            'file.string' => 'Url video harus berupa string!',
            'file.regex' => 'Kolom URL video harus diisi dengan link (http / https)',
        ];

        $validator = Validator::make($request->all(), [
            'header' => 'required|max:255',
            'file' => [
                "regex:{$url_regex}",
                'required',
                'string',
            ],

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }


        $header = $request->header;
        $file = $request->file;

        $updateData = [
            'header' => $header,
            'file' => $file,
        ];

        $result = $this->VideoHomeRepository->update($id,$updateData);


        if ($result) {
            return redirect()->route('video_home.index')
                ->with('success', 'Data Video Home Default Panel telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data Video Home Default Panel');
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
                ->with('success', 'Data Video Home Default Panel telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data kategori Video Home Default Panel');
        }
    }
}
