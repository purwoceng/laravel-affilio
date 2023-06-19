<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Models\ProductAffilio;
use App\Repositories\Products\ProductAffilioRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductAffilioController extends Controller
{
    protected $affilio_repository;

    public function __construct(ProductAffilioRepository $affilio_repository)
    {
        $this->affilio_repository = $affilio_repository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->affilio_repository
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

        return view('products.recommendation_affilio.index');
    }

    public function create()
    {
        $arr_range = range(1, 25);
        $data = ProductAffilio::whereNull('deleted_at')->get();

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

        return view('products.recommendation_affilio.create', compact('available_numbers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric|min:1',
            'queue_number' => 'required|numeric|min:1|max:100',
        ]);

        $product_affilio = ProductAffilio::create([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'queue_number' => $request->queue_number,
            'is_active' => '1',
        ]);

        if ($product_affilio) {
            return redirect()
                ->route('recommendation_affilio.index')
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
        $product = ProductAffilio::findOrFail($id);

        if ($product) {
            $arr_range = range(1, 25);
            $data = ProductAffilio::where('id', '!=', $id)->whereNull('deleted_at')->get();

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
            $url = config('app.baleomol_url') . '/affiliator/products?appx=true' . $product['product_id'];
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get($url);

            $real_product['product_data'] = $response['data'];

            return view(
                'products.recommendation_affilio.edit',
                compact('product', 'available_numbers', 'real_product'),
            );
        } else {
            return redirect()
                ->route('recommendation_affilio.index')
                ->with([
                    'error' => "Gagal mengedit data - produk rekomendasi affilio dengan id {$id} tidak ditemukan.",
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'product_id' => 'required|numeric|min:1',
            'queue_number' => 'required|numeric|min:1|max:100',
        ]);

        $product = ProductAffilio::findOrFail($id);
        $product->product_id = $request->product_id;
        $product->type = $request->type;
        $product->queue_number = $request->queue_number;
        $product->is_active = $request->is_active;
        $product->save();

        if ($product) {
            return redirect()
                ->route('recommendation_affilio.index')
                ->with([
                    'success' => 'Berhasil mengedit data produk rekomendasi affilio.'
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

        $arr_range = range(1, 25);

        $data = ProductAffilio::where('id', '!=', $exception_id)->where('is_active', 1)->get();

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
        $product = ProductAffilio::find($id);

        if ($product) {
            $product->is_active = '0';
            $product->save();

            $product->delete();

            return redirect()
                ->route('recommendation_affilio.index')
                ->with([
                    'success' => 'Berhasil menghapus data produk rekomendasi affilio.'
                ]);
        } else {
            return redirect()
                ->route('recommendation_affilio.index')
                ->with([
                    'error' => "Gagal menghapus data - Produk rekomendasi Affilio dengan id {$id} tidak ditemukan.",
                ]);
        }
    }
}
