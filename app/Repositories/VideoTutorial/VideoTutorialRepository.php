<?php

namespace App\Repositories\VideoTutorial;

use App\Models\VideoTutorial;
use App\Repositories\Interfaces\VideoTutorial\VideoTutorialRepositoryInterface;

class VideoTutorialRepository implements VideoTutorialRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return VideoTutorial::create($data);
    }

    public function update($id, array $data)
    {
        return VideoTutorial::where('id',$id)->update($data);
    }
    public function getVideoTutorialById($id)
    {
        return VideoTutorial::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountVideoTutorials()
    {
        return VideoTutorial::all()->count();
    }

    public function getVideoTutorials($limit, $start)
    {
        return VideoTutorial::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $video_query = $this->getVideoTutorials($limit, $start);
        $total_data = $this->getCountVideoTutorials();

        $videos = $video_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($videos)) {
            foreach ($videos  as $key => $video) {
                $id = $video->id;
                $name = $video->name;
                $video_url = $video->url;
                $member_type_id = $video->member_type_id;
                $image = $video->image ? config('app.s3_url') . $video->image : '';
                $created_at = date('d/m/Y H:i', strtotime($video->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'name',
                    'video_url',
                    'member_type_id',
                    'image',
                    'created_at',
                    'actions',
                );
            }
        }

        $result = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data,
        ];

        return $result;
    }
}
