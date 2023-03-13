<?php

namespace App\Repositories\VideoHome;

use App\Models\VideoHome;
use App\Repositories\Interfaces\VideoHome\VideoHomeRepositoryInterface;

class VideoHomeRepository implements VideoHomeRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return VideoHome::create($data);
    }

    public function update($id, array $data)
    {
        return VideoHome::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return VideoHome::where('id',$id)->delete();
    }

    public function getVideoHomeById($id)
    {
        return VideoHome::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountVideoHome()
    {
        return VideoHome::all()->count();
    }

    public function getVideoHome($limit, $start)
    {
        return VideoHome::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $video_query = $this->getVideoHome($limit, $start);
        $total_data = $this->getCountVideoHome();

        $videos = $video_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($videos)) {
            foreach ($videos  as $key => $video) {
                $id = $video->id;
                $header = $video->header;
                $file = $video->video? config('app.s3_url') . $video->file : '';
                $created_at = date('Y-m-d H:i', strtotime($video->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'header',
                    'file',
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
