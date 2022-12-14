<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\ProductHome;
use App\Repositories\HomePage\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    protected $product_repository;

    public function __construct(ProductRepository $product_repository)
    {
        $this->product_repository = $product_repository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->product_repository
                ->getDataTable($request);

            $products = $data['data'];

            $result = [];

            foreach ($products as $product) {
                $token = config('app.baleomol_key');
                $url = config('app.baleomol_url') . '/products/' . $product['product_id'];

                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                ])->get($url);

                $product['product_data'] = $response['data'];

                $result[] = $product;
            }

            $data['data'] = $result;

            return response()->json($data);
        }

        return view('content.product_home.index');
    }

    public function create()
    {
        return view('content.product_home.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'numeric|min:1|unique:product_home,product_id',
            'queue_number' => 'numeric|min:1|max:100',
        ]);

        $product_home = ProductHome::create([
            'product_id' => $request->product_id,
            'queue_number' => $request->queue_number,
            'product_home_type_id' => 1,
            'is_active' => 1,
            'redis_key' => '',
        ]);

        if ($product_home) {
            return redirect()
                ->route('product_home.index')
                ->with([
                    'success' => 'Berhasil menambah data baru produk rekomendasi.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat menambah data. Mohon coba kembali'
                ]);
        }
    }

    public function edit($id)
    {
        $product_home = ProductHome::findOrFail($id);

        return view('content.product_home.edit');
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, []);
    }

}
