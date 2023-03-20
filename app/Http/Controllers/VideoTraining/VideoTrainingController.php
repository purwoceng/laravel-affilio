<?php

namespace App\Http\Controllers\VideoTraining;

use Illuminate\Http\Request;
use App\Models\VideoTraining;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\VideoTraining\VideoTrainingRepository;

class VideoTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $videoTrainingRepository;

     public function __construct(VideoTrainingRepository $videoTrainingRepository)
     {
         $this->VideoTrainingRepository = $videoTrainingRepository;
     }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->VideoTrainingRepository->getDataTable($request);
        }
        return view('video_training.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('video_training.create');
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
            'name.required' => 'Nama tidak boleh kosong',
            'categories.required' => 'Kategori Video tidak boleh kosong',
            'url.required' => 'url video tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'categories' => 'required|max:255',
            'file'=> 'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv ',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $name = $request->name;
        $categories = $request->categories;

        $createData = [
            'name' => $name,
            'categories' => $categories,

        ];

        $file = $request->file('file');

        if($file) {
            $filename = 'Video-' . time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/videohome/'), $filename);
            $path_file = 'storage/system_storage/videohome/' . $filename;
            $createData['file'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/videohome/') . $filename));

        }
        $result = $this->VideoTrainingRepository->create($createData);

        if ($result) {
            return redirect()->route('video_training.index')
                ->with('success', 'Data Video Training telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data video training');
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
        $data = $this->VideoTrainingRepository->getVideoTrainingById($id);
        return view('video_training.detail', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $video = VideoTraining::findorfail($id);
        return view('video_training.edit',compact('video'));
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
            'categories.required' => 'Kategori Video tidak boleh kosong',
            'file.required' => 'url video tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:100',
            'file'=> 'required|mimes:mp4,x-flv,x-mpegURL,MP2T,3gpp,quicktime,x-msvideo,x-ms-wmv ',

        ], $messages);


        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

       $name = $request->name;
        $categories = $request->categories;

        $createData = [
            'name' => $name,
            'categories' => $categories,

        ];

        $file = $request->file('file');

        if($file) {
            $filename = 'Video-' . time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
            $file->move(public_path('storage/videohome/'), $filename);
            $path_file = 'storage/system_storage/videohome/' . $filename;
            $createData['file'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/videohome/') . $filename));

        }
        $result = $this->VideoTrainingRepository->update($id,$createData);

        if ($result) {
            return redirect()->route('video_training.index')
                ->with('success', 'Data Video Training telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data video training');
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
        $delete = $this->VideoTrainingRepository->delete($id);

        if ($delete) {
            return redirect()->route('video_training.index')
                ->with('success', 'Data Video Training telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data video training');
        }
    }
}
