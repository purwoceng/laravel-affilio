<?php

namespace App\Http\Controllers\VideoTutorial;

use App\Http\Controllers\Controller;
use App\Models\MemberType;
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
                    'member_type' => $member_type->name ?? '-',
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
        return view('video_tutorials.create');
    }

    public function store(Request $request)
    {
        $validation_messages = [
            'name.required' => 'Nama video wajib diisi!',
            'name.max_digits' => 'Karakter untuk nama video maksimal :digits!',
        ];

        $validation = Validator::make(
            $request->all(),
            [
                'name' => ['required', 'max_digits:64', ],
                'video' => ['required', 'string', 'max_digits:200'],
                'member_type_id' => [
                    'required',
                    Rule::exists('member_types', 'id'),
                ],
            ],
            $validation_messages,
        );
    }

    public function update(Request $request, $id)
    {

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
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus.',
                    'data' => $response_data,
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'message' => 'Gagal menghapus data.',
                    'data' => $response_data,
                ]);
            }
        } catch (Exception $err) {
            return response()->json([
                'success' => false,
                'message' => "Gagal menghapus data video dengan id {$id}. Data tidak ditemukan atau telah dihapus",
                'data' => [],
                'exception' => $err,
            ]);
        }
    }
}
