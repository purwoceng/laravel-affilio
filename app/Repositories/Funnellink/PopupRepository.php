<?php

namespace App\Repositories\Funnellink;

use App\Models\Popup;
use App\Repositories\Interfaces\Funnellink\PopupRepositoryInterface;

class PopupRepository implements PopupRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return Popup::create($data);
    }

    public function update($id, array $data)
    {
        return Popup::where('id', $id)->update($data);
    }

    public function delete($id)
    {
        return Popup::where('id', $id)->delete();
    }

    public function getPopupById($id)
    {
        return Popup::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountPopup()
    {
        return Popup::all()->count();
    }

    public function getPopup($limit, $start)
    {
        return Popup::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit =$request->input('length');
        $start =$request->input('start');

        $popup_query = $this->getPopup($limit, $start);
        $total_data = $this->getCountPopup();
    
        $popups = $popup_query->orderBy('id', 'desc')->get();
        $data = [];

        if (!empty($popups)) {
            foreach ($popups as $key =>$popup) {
                $id = $popup->id;
                $title = $popup->title;
                $image = $popup->image ? config('app.s3_url') . $popup->image : '';
                $url = $popup->url ?? '-';
                $created_at = date('Y-m-d H:i', strtotime($popup->created_at));
                $actions =$id;

                $data[] = compact(
                    'id',
                    'title',
                    'image',
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

        return response()->json($result);
    }


}
