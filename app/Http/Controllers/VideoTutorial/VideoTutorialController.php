<?php

namespace App\Http\Controllers\VideoTutorial;

use App\Http\Controllers\Controller;
use App\Repositories\VideoTutorial\VideoTutorialRepository;
use Illuminate\Http\Request;

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
            $data = $result['data'];

            

            return response()->json($result);
        }

        return view('video_tutorials.index');
    }
}
