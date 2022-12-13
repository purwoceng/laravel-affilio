<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\ProductHome;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index(Request $request)
    {
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
