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
                $token = config('app.baleomol_token_auth');
                $url = config('app.baleomol_url') . '/affiliator/products/' . $product['product_id'] . '?appx=true';

                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                ])->get($url);

                $product['product_data'] = $response['data'];

                $result[] = $product;
            }

            $data['data'] = $result;

            // dd($data);
            // exit;

            return response()->json($data);
        }

        return view('content.product_home.index');
    }

    public function create()
    {
        $arr_range = range(501, 1000);
        $data = ProductHome::whereNull('deleted_at')->get();

        $exists_numbers = array_map(function ($product) {
            return $product->queue_number;
        }, json_decode(json_encode($data, true)));

        $available_numbers = array_filter(
            $arr_range,
            function ($number) use ($exists_numbers) {
                if (in_array($number, $exists_numbers)) return false;
                return true;
            }
        );

        return view('content.product_home.create', compact('available_numbers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric|min:1',
            'queue_number' => 'required|numeric|min:1|max:1000',
        ]);

        $product_home = ProductHome::create([
            'product_id' => $request->product_id,
            'name' => $request->name,
            'type' => $request->type,
            'queue_number' => $request->queue_number,
            'is_active' => '1',
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
        $product = ProductHome::findOrFail($id);

        if ($product) {
            $arr_range = range(501, 1000);
            $data = ProductHome::where('id', '!=', $id)->whereNull('deleted_at')->get();

            $exists_numbers = array_map(function ($product) {
                return $product->queue_number;
            }, json_decode(json_encode($data, true)));

            $available_numbers = array_filter(
                $arr_range,
                function ($number) use ($exists_numbers) {
                    if (in_array($number, $exists_numbers)) return false;
                    return true;
                }
            );

            $token = config('app.baleomol_token_auth');
            $url = config('app.baleomol_url') . '/affiliator/products/' . $product['product_id'] . '?appx=true';
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get($url);

            $real_product = $response['data'];

            return view(
                'content.product_home.edit',
                compact('product', 'available_numbers', 'real_product'),
            );
        } else {
            return redirect()
                ->route('product_home.index')
                ->with([
                    'error' => "Gagal mengedit data - produk rekomendasi dengan id {$id} tidak ditemukan.",
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric|min:1',
            'queue_number' => 'required|numeric|min:1|max:1000',
        ]);

        $product = ProductHome::findOrFail($id);
        $product->product_id = $request->product_id;
        $product->name = $request->name;
        $product->type = $request->type;
        $product->queue_number = $request->queue_number;
        $product->is_active = $request->is_active;
        $product->save();

        if ($product) {
            return redirect()
                ->route('product_home.index')
                ->with([
                    'success' => 'Berhasil mengedit data produk rekomendasi.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat mengedit data. Mohon coba kembali'
                ]);
        }
    }

    public function getAvailableQueueNumber(Request $request)
    {
        $exception_id = $request->exception_id ?? 0;
        $type_id = $request->type_id ?? 0;

        $arr_range = range(501, 1000);

        $data = ProductHome::where('id', '!=', $exception_id)->where('is_active', 1)->get();

        $exists_numbers = array_map(function ($product) {
            return $product->queue_number;
        }, json_decode(json_encode($data, true)));

        $available_numbers = array_filter(
            $arr_range,
            function ($number) use ($exists_numbers) {
                if (in_array($number, $exists_numbers)) return false;
                return true;
            }
        );

        return response()->json(['available_numbers' => array_values($available_numbers)]);
    }

    public function delete($id)
    {
        $product = ProductHome::find($id);

        if ($product) {
            $product->is_active = '0';
            $product->save();

            $product->delete();

            return redirect()
                ->route('product_home.index')
                ->with([
                    'success' => 'Berhasil menghapus data produk rekomendasi.'
                ]);
        } else {
            return redirect()
                ->route('product_home.index')
                ->with([
                    'error' => "Gagal menghapus data - Produk rekomendasi dengan id {$id} tidak ditemukan.",
                ]);
        }
    }
}
