<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\ProductHomeType;
use App\Repositories\Interfaces\HomePage\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    protected $product_home_repository;

    public function __construct(ProductRepositoryInterface $productRepositoryInterface)
    {
        $this->product_home_repository = $productRepositoryInterface;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->product_home_repository
                ->getProductHomeTypeDataTable($request);

            return response()->json($data);
        }

        return view('content.product_home.types');
    }

    public function create()
    {
        return view('content.product_home.create-type');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'code' => 'required|string|max:64|unique:product_home_types,code',
        ]);

        $type = ProductHomeType::create([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        if ($type) {
            return redirect()
                ->route('product_home.types')
                ->with([
                    'success' => 'Berhasil menambah tipe produk rekomendasi',
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => "Terjadi kesalahan. Data '{$request->code}' mungkin sudah ada di sistem."
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|max:64',
            'code' => 'required|string|max:64',
        ]);

        $type = ProductHomeType::findOrFail($id);

        $type->update([
            'name' => $request->name,
            'code' => $request->code,
        ]);

        if ($type) {
            return redirect()
                ->route('product_home.types')
                ->with([
                    'success' => 'Berhasil memperbarui tipe produk rekomendasi',
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => "Terjadi kesalahan. Data '{$request->code}' tidak ditemukan di sistem."
                ]);
        }
    }

    public function edit($id)
    {
        $type = ProductHomeType::findOrFail($id);
        return view('content.product_home.update-type', compact('type'));
    }

    public function delete($id)
    {
        $type = ProductHomeType::findOrFail($id);

        if ($type) {
            $name = $type->name;
            $type->delete();
            
            return redirect()
                ->route('product_home.types')
                ->with([
                    'success' => "Berhasil menghapus tipe ${name}.",
                ]);
        } else {
            return redirect()
                ->route('product_home.types')
                ->with([
                    'success' => "Tipe dengan id {$id} tidak ditemukan.",
                ]);
        }
    }
}
