<?php

namespace App\Repositories\Funnellink;

use App\Models\FunnelLink;
use App\Repositories\Interfaces\Funnellink\FunnelLinkRepositoryInterface;

class FunnelLinkRepository implements FunnelLinkRepositoryInterface
{
    public function __construct()
    {
        //
    }

    public function create(array $data)
    {
        return FunnelLink::create($data);
    }

    public function update($id, array $data)
    {
        return FunnelLink::where('id',$id)->update($data);
    }

    public function delete($id)
    {
        return FunnelLink::where('id',$id)->delete();
    }

    public function getLinkById($id)
    {
        return FunnelLink::where('id', $id)->whereNull('deleted_at')->first();
    }

    public function getCountLink()
    {
        return FunnelLink::all()->count();
    }

    public function getLink($limit, $start)
    {
        return FunnelLink::offset($start)->limit($limit);
    }

    public function getDataTable($request)
    {
        $limit = $request->input('length');
        $start = $request->input('start');

        $link_query = $this->getLink($limit, $start);
        $total_data = $this->getCountLink();

        $links = $link_query->orderBy('id', 'desc')->get();
        $data =  [];

        if (!empty($links)) {
            foreach ($links  as $key => $link) {
                $id = $link->id;
                $type = $link->type;
                $url = $link->url ?? '-';
                $description = $link->description ?? '-';
                $created_at = date('Y-m-d H:i', strtotime($link->created_at));
                $actions = $id;

                $data[] = compact(
                    'id',
                    'type',
                    'url',
                    'description',
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
