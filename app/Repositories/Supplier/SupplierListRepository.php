<?php

namespace App\Repositories\Supplier;

use App\Repositories\Interfaces\Supplier\SupplierListRepositoryInterface;
use Illuminate\Support\Facades\Http;

class SupplierListRepository implements SupplierListRepositoryInterface
{
    private $totalSupplier = 0;
    private $totalPage = 0;

    private $currentPage = 1;


    public function __construct()
    {
        //
    }
    public function getSupplier($limit, $page, $username, $storeName )
    {
        $token = config('app.baleomol_key');
        $url = config('app.baleomol_url') . '/suppliers?req=affilio';
        if($limit){
            $url.='&limit='.(int)$limit;
        }

        if($page){
            $url.='&page='.$page;
        }

        if($username){
            $url.='&username='.$username;
        }

        if($storeName){
            $url.='&name='.$storeName;
        }

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get($url);


        $data = $response['data'] ?? [];
        $results = $data['results'] ?? [];
        $pagination = $data['pagination'] ?? [];
        $this->totalSupplier = $pagination['totalData'] ?? 0;
        $this->totalPage = $pagination['totalPage'] ?? 0;

        return  $results ?? [];
    }

    public function getTotalSupplier()
    {
        //return SupplierList::whereNull('deleted_at')->count();
    }
    public function getDataTable($request)
    {
        $limit = $request->input('length') ?? 20 ;
        $start = $request->input('start') ?? 1;
        $username = $request->input('username') ?? '';
        $page = (floor($start / $limit)) + 1;
        $storeName = $request->input('storeName') ?? '';

        $suppliers = $this->getSupplier($limit, $page, $username, $storeName);
        $total_data = $this->totalSupplier;

        $data = [];

        if (!empty($suppliers)) {
            foreach ($suppliers  as $supplier) {
                $username = $supplier['username'];
                $name = $supplier['name'];
                $store = $supplier['store']['storeName'];
                $id = $supplier['id'];
                $created_at = $supplier['dateRegistration'];

                $data[] = [
                    'username' => $username,
                    'name' => $name,
                    'storeName' => $store,
                    'id' => $id,
                    'created_at' => date('d-m-Y H:i', strtotime($created_at)),
                ];
            }
        }

        $result = [
            'draw' =>$page,
            'recordsTotal' => intval($total_data),
            'recordsFiltered' => intval($total_data),
            'data' => $data,
        ];

        return $result;
    }
}
