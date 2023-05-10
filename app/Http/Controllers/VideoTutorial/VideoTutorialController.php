<?php

namespace App\Http\Controllers\VideoTutorial;

use Exception;
use App\Models\MemberType;
use Illuminate\Http\Request;
use App\Models\VideoTutorial;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Repositories\VideoTutorial\VideoTutorialRepository;

class VideoTutorialController extends Controller
{
    protected $repository;
    public $member_types;

    public function __construct(VideoTutorialRepository $video_tutorial_repository)
    {
        $this->repository = $video_tutorial_repository;
        $this->member_types = [
            [
                'id' => 1,
                'name' => 'Affiliator',
            ],
            [
                'id' => 2,
                'name' => 'Affiliator Inti',
            ],
            [
                'id' => 3,
                'name' => 'Bronze',
            ],

            [
                'id' => 4,
                'name' => 'Gold',
            ],

            [
                'id' => 5,
                'name' => 'Bronze',
            ],

            [
                'id' => 6,
                'name' => 'Platinum',
            ],

            [
                'id' => 7,
                'name' => 'Diamond',
            ],

            [
                'id' => 8,
                'name' => 'Semua',
            ],

        ];
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->repository->getDataTable($request);
            $data = array_map(function($item) {
                $member_type = MemberType::where('id', $item['member_type_id'])->first();
                $new_item = array_merge($item, [
                    'member_type' => $member_type->type ?? '-',
                ]);

                return $new_item;
            }, $result['data']);
            $result['data'] = $data;

            return response()->json($result);
        }

        return view('video_tutorials.index');
    }

    public function show($id)
    {
        try {
            $data = $this->repository->getVideoTutorialById($id);

            if (!$data) {
                throw new Exception("Data video dengan id {$id} tidak ditemukan");
            }

            return response()->json([
                'success' => true,
                'message' => 'Data ditemukan.',
                'data' => $data,
            ]);
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'message' => "Gagal mendapatkan data video dengan id {$id}.",
                'data' => [],
                'exception' => $err,
            ]);
        }
    }

    public function create()
    {
        $member_types = MemberType::whereNull('deleted_at')->get();

        return view('video_tutorials.create', compact('member_types'));
    }

    public function store(Request $request)
    {
        $url_regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        $validation_messages = [
            'name.required' => 'Judul video wajib diisi!',
            'url.required' => 'URL video wajib diisi!',
            'url.string' => 'Url video harus berupa string!',
            'url.regex' => 'Kolom URL video harus diisi dengan link (http / https)',
            'member_type_id.required' => 'Tipe member wajib diisi!',
            'member_type_id.exists' => 'Tipe member tidak valid. Muat ulang halaman!',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'url' => [
                    "regex:{$url_regex}",
                    'required',
                    'string',
                ],
                'member_type_id' => [
                    'required',
                    Rule::exists('member_types', 'id'),
                ],
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $createData = [
            'name' => $request->name,
            'url' => $request->url,
            'member_type_id' => $request->member_type_id,
        ];

        $image = $request->file('image');

        if($image) {
            $filename = 'Image-' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/video_tutorials/thumbnail/'), $filename);
            $path_file = 'storage/system_storage/video_tutorials/thumbnail/' . $filename;
            $createData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/video_tutorials/thumbnail/') . $filename));

        }

        $result = $this->repository->create($createData);

        if ($result) {
            return redirect()
                ->route('video_tutorials.index')
                ->with([
                    'success' => 'Berhasil menambah data tutorial video baru.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat menambah data. Mohon coba kembali!'
                ]);
        }
    }

    public function edit($id)
    {
        $video_tutorial = VideoTutorial::findOrFail($id);

        if ($video_tutorial) {
            $member_types = MemberType::whereNull('deleted_at')->get();

            return view(
                'video_tutorials.edit',
                compact('video_tutorial', 'member_types'),
            );
        } else {
            return redirect()
                ->route('video_tutorials.index')
                ->with([
                    'error' => "Gagal mengedit data - video tutorial dengan id {$id} tidak ditemukan.",
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $url_regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        $validation_messages = [
            'name.required' => 'Judul video wajib diisi!',
            'url.required' => 'URL video wajib diisi!',
            'url.string' => 'Url video harus berupa string!',
            'url.regex' => 'Kolom URL video harus diisi dengan link (http / https)',
            'member_type_id.required' => 'Tipe member wajib diisi!',
            'member_type_id.exists' => 'Tipe member tidak valid. Muat ulang halaman!',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'url' => ['required', 'string', "regex:{$url_regex}"],
                'member_type_id' => [
                    'required',
                    Rule::exists('member_types', 'id'),
                ],
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'url' => $request->url,
            'member_type_id' => $request->member_type_id,
        ];

        $image = $request->file('image');

        if($image) {
            $filename = 'Image-' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/video_tutorials/thumbnail/'), $filename);
            $path_file = 'storage/system_storage/video_tutorials/thumbnail/' . $filename;
            $updateData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/video_tutorials/thumbnail/') . $filename));

        }

        $result = $this->repository->create($updateData);


        if ($result) {
            return redirect()
                ->route('video_tutorials.index')
                ->with([
                    'success' => 'Berhasil memperbarui data tutorial video.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat memperbarui data. Mohon coba kembali!'
                ]);
        }
    }

    public function delete($id)
    {
        try {
            $data = $this->repository->getVideoTutorialById($id);

            if (!$data) {
                throw new Exception("Data video dengan id {$id} tidak ditemukan atau telah dihapus");
            }

            $response_data = $data;

            if ($data->delete()) {
                return redirect()
                    ->route('video_tutorials.index')
                    ->with([
                        'success' => 'Berhasil menghapus data video tutorial.'
                    ]);
            } else {
                return redirect()
                    ->route('video_tutorials.index')
                    ->with([
                        'error' => "Gagal menghapus data - Video tutorial dengan id {$id} tidak ditemukan.",
                    ]);
            }
        } catch (Exception $err) {
            return redirect()
                ->route('video_tutorials.index')
                ->with([
                    'error' => "Gagal menghapus data - Video tutorial dengan id {$id} tidak ditemukan.",
                ]);
        }
    }
}
