<?php

namespace App\Http\Controllers\VideoTutorial;

use App\Http\Controllers\Controller;
use App\Models\MemberType;
use App\Models\VideoTutorial;
use App\Repositories\VideoTutorial\VideoTutorialRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
                'name' => 'Member',
            ],
            [
                'id' => 2,
                'name' => 'Core member',
            ],
            [
                'id' => 3,
                'name' => 'Leader',
            ],
            
            [
                'id' => 4,
                'name' => 'Super Leader',
            ],
        
            [
                'id' => 5,
                'name' => 'Bronze',
            ],
    
            [
                'id' => 6,
                'name' => 'Super Bronze',
            ],

            [
                'id' => 7,
                'name' => 'Silver',
            ],

            [
                'id' => 8,
                'name' => 'Super Silver',
            ],

            [
                'id' => 9,
                'name' => 'Gold',
            ],

            [
                'id' => 10,
                'name' => 'Super Gold',
            ],
            [
                'id' => 11,
                'name' => 'Platinum',
            ],
            [
                'id' => 12,
                'name' => 'Super Platinum',
            ],
            [
                'id' => 13,
                'name' => 'Diamond',
            ],
            [
                'id' => 14,
                'name' => 'Super Diamond',
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

        $video_tutorial = VideoTutorial::create([
            'name' => $request->name,
            'url' => $request->url,
            'member_type_id' => $request->member_type_id,
        ]);

        if ($video_tutorial) {
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

        $video_tutorial = VideoTutorial::findOrFail($id);
        $video_tutorial->name = $request->name;
        $video_tutorial->url = $request->url;
        $video_tutorial->member_type_id = $request->member_type_id;
        $video_tutorial->save();

        if ($video_tutorial) {
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
                        'success' => 'Berhasil menghapus data produk video tutorial.'
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
