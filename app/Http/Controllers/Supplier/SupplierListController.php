<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupplierNonActive;
use Illuminate\Support\Facades\Http;
use App\Repositories\Supplier\SupplierListRepository;

class SupplierListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $SupplierListRepository;

    public function __construct(SupplierListRepository $SupplierListRepository)
    {
        $this->SupplierListRepository = $SupplierListRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $suppliers = $this->SupplierListRepository
                ->getDataTable($request);


            return response()->json($suppliers);
        }

        return view('suppliers.list.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // $supplierslist= [$id];
        // $suppliers_id = $supplierslist;
        // $token = config('app.baleomol_key');
        // $url = config('app.baleomol_url') . '/suppliers/' ;

        // $response = Http::withHeaders([
        //     'Authorization' => "Bearer {$token}",
        // ])->get($url);

        // $data = $response['data'] ?? [];
        // $results = $data['results'] ?? [];
        // return  $results ?? [];

        // $product_data = $response['results'];
        // dd($product_data);
        // exit;
        // return view('suppliers.list.createnonactive',compact('results'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
