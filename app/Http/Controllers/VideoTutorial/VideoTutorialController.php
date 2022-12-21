<?php

namespace App\Http\Controllers\VideoTutorial;

use App\Http\Controllers\Controller;
use App\Repositories\VideoTutorial\VideoTutorialRepository;
use Illuminate\Http\Request;

class VideoTutorialController extends Controller
{
    protected $repository;

    public function __construct(VideoTutorialRepository $video_tutorial_repository)
    {
        $this->repository = $video_tutorial_repository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $result = $this->repository->getDataTable($request);

            return response()->json($result);
        }

        return view('video_tutorials.index');
    }
}
