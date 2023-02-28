<?php

namespace App\Repositories\Member;

use App\Models\MemberType;
use App\Repositories\Interfaces\Member\MemberTypeRepositoryInterface;

class MemberTypeRepository implements MemberTypeRepositoryInterface
{
    public function __construct()
    {

    }

    public function create(array $data)
    {
        return MemberType::create($data);
    }

    public function update($id, array $data)
    {
        return MemberType::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return MemberType::where('id',$id)->delete();
    }


    public function getMemberType($limit, $start)
    {
        return MemberType::offset($start)->limit($limit);
    }

    public function getCountMemberType()
    {
        return MemberType::count();
    }
    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $getQuery = $this->getMemberType($limit, $start);
        $totalData = $this->getCountMemberType();
        $totalFiltered = $totalData;

        if ($request->filled('type')) {
            $keyword = $request->get('type');
            $getQuery->where('type', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        if ($request->filled('min_omset')) {
            $keyword = $request->get('min_omset');
            $getQuery->where('min_omset', 'like', '%' . $keyword . '%');
            $totalData = $getQuery->count();
            $totalFiltered = $totalData;
        }

        $getMemberType = $getQuery->orderBy('id', 'desc')->get();

        $dataArray = [];
        if (!empty($getMemberType)) {
            foreach ($getMemberType as $key => $getMemberType) {
                $id = $getMemberType->id;
                $type = $getMemberType->type;
                $image = $getMemberType->image;
                $image_url = $getMemberType->image ? config('app.s3_url') . $getMemberType->image : '';
                $min_omset = $getMemberType->min_omset??'-';
                $created_at = date('Y-m-d H:i', strtotime($getMemberType->created_at));
                $updated_at = date('Y-m-d H:i', strtotime($getMemberType->updated_at));
                $dataArray[] = [
                    'id' => $id,
                    'type' => $type,
                    'image' => $image,
                    'image_url' => $image_url,
                    'min_omset' => $min_omset,
                    'created_at'=> $created_at,
                    'updated_at'=> $updated_at,
                    'actions' => $id,
                ];
            }
        }

        $json_data = array(
            "draw"            => intval($request->input('draw')),
            "recordsTotal"    => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data"            => $dataArray
        );

        echo json_encode($json_data);
    }

    public function getDataByID($id)
    {
        return MemberType::where('id',$id)->first();
    }
}
