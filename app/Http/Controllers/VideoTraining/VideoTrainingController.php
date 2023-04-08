<?php

namespace App\Http\Controllers\VideoTraining;

use App\Models\MemberType;
use Illuminate\Http\Request;
use App\Models\VideoTraining;
use Illuminate\Validation\Rule;
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
            $result = $this->VideoTrainingRepository->getDataTable($request);
            $data = array_map(function($item) {
                $member_type = MemberType::where('id', $item['member_type_id'])->first();
                $new_item = array_merge($item, [
                    'member_type_id' => $member_type->type ?? '-',
                ]);

                return $new_item;
            }, $result['data']);
            $result['data'] = $data;

            return response()->json($result);
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
        $member_types = MemberType::whereNull('deleted_at')->get();
        return view('video_training.create',compact('member_types'));
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
            'title.required' => 'Judul Video tidak boleh kosong',
            'url.required' => 'url video tidak boleh kosong',
            'url.regex' => 'Kolom URL video harus diisi dengan link (http / https)',
            'member_type_id.required' => 'Tipe member wajib diisi!',
            'member_type_id.exists' => 'Tipe member tidak valid. Muat ulang halaman!',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'url' => [
                "regex:{$url_regex}",
                'required',
                'string',
            ],
            'member_type_id' => [
                'required',
                Rule::exists('member_types', 'id'),
            ],

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $title = $request->title;
        $url = $request->url;
        $member_type_id = $request->member_type_id;

        $createData = [
            'title' => $title,
            'url' => $url,
            'member_type_id' => $member_type_id,

        ];

        // $file = $request->file('file');

        // if($file) {
        //     $filename = 'Video-' . time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('storage/videohome/'), $filename);
        //     $path_file = 'storage/system_storage/videohome/' . $filename;
        //     $createData['file'] = $path_file;
        //     Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/videohome/') . $filename));

        // }
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
        if ($data) {
            $member_types = MemberType::whereNull('deleted_at')->get();
        return view('video_training.detail', compact('data','member_types'));
        }
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
        if ($video) {
            $member_types = MemberType::whereNull('deleted_at')->get();
        return view('video_training.edit',compact('video','member_types'));
        } else {
            return redirect()
                ->route('video_training.index')
                ->with([
                    'error' => "Gagal mengedit data - video tutorial dengan id {$id} tidak ditemukan.",
                ]);
        }
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
            'title.required' => 'Judul Video tidak boleh kosong',
            'url.required' => 'Url Video tidak boleh kosong',
            'url.regex' => 'Kolom URL video harus diisi dengan link (http / https)',
            'member_type_id.required' => 'Tipe member wajib diisi!',
            'member_type_id.exists' => 'Tipe member tidak valid. Muat ulang halaman!',

        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:100',
            'url' => [
                "regex:{$url_regex}",
                'required',
                'string',
            ],
            'member_type_id' => [
                'required',
                Rule::exists('member_types', 'id'),
            ],

        ], $messages);


        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $title = $request->title;
        $url = $request->url;
        $member_type_id = $request->member_type_id;

        $updateData = [
            'title' => $title,
            'url' => $url,
            'member_type_id' => $member_type_id,

        ];

        // $file = $request->file('file');

        // if($file) {
        //     $filename = 'Video-' . time() . '_' . uniqid() . '_' . $file->getClientOriginalName();
        //     $file->move(public_path('storage/videohome/'), $filename);
        //     $path_file = 'storage/system_storage/videohome/' . $filename;
        //     $updateData['file'] = $path_file;
        //     Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/videohome/') . $filename));

        // }
        $result = $this->VideoTrainingRepository->update($id,$updateData);

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
