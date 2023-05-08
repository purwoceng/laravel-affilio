<?php

namespace App\Repositories\VideoTraining;

use App\Models\VideoTraining;
use App\Repositories\Interfaces\VideoTraining\VideoTrainingRepositoryInterface;

class VideoTrainingRepository implements VideoTrainingRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return VideoTraining::create($data);
    }

    public function update($id, array $data)
    {
        return VideoTraining::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return VideoTraining::where('id',$id)->delete();
    }

    public function getVideoTrainingById($id)
    {
        return VideoTraining::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountVideoTraining()
    {
        return VideoTraining::all()->count();
    }

    public function getVideoTraining($limit, $start)
    {
        return VideoTraining::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $video_query = $this->getVideoTraining($limit, $start);
        $total_data = $this->getCountVideoTraining();

        $videos = $video_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($videos)) {
            foreach ($videos  as $key => $video) {
                $id = $video->id;
                $member_type_id = $video->member_type_id;
                $name = $video->name;
                $url = $video->url;
                $created_at = date(' d F Y H:i', strtotime($video->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'member_type_id',
                    'name',
                    'url',
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
