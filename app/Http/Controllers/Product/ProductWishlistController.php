<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\Request;
use App\Models\ProductWishlist;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use App\Repositories\Products\ProductWishlistRepository;

class ProductWishlistController extends Controller
{
    protected $repository;

    public function __construct(ProductWishlistRepository $productWishlistRepository)
    {
        $this->repository = $productWishlistRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->repository->getDataTable($request);
        }
        return view('products.wishlist.index');
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
     * @param  \App\Models\ProductWishlist  $productWishlist
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $productWishlist = ProductWishlist::where('id',$id)->first();
        $product_id = $productWishlist->product_id;
        // $token = config('app.baleomol_key');
        // $url = config('app.baleomol_url') . '/products/' . $product_id;
        $token = config('app.baleomol_token_auth');
        $url = config('app.baleomol_url') . '/affiliator/products/'.$product_id.'?appx=true' ;

        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get($url);

        $product_data = $response['data'];
        // dd($product_data);
        // exit;
        return view('products.wishlist.show',compact('product_data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProductWishlist  $productWishlist
     * @return \Illuminate\Http\Response
     */
    public function edit(ProductWishlist $productWishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProductWishlist  $productWishlist
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProductWishlist $productWishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProductWishlist  $productWishlist
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProductWishlist $productWishlist)
    {
        //
    }
}
