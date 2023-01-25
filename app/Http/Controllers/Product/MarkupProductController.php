<?php

namespace App\Http\Controllers\Product;

use App\Http\Controllers\Controller;
use App\Repositories\content\GlobalSettingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class MarkupProductController extends Controller
{
    protected $repository;

    public function __construct(GlobalSettingRepository $globalSettingRepository)
    {
        $this->repository = $globalSettingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->repository
                ->getDataTable($request);

            $markup_products = $data['data'];

            $result = [];

            foreach ($markup_products as $markup) {
                $product_id = str_replace('markup_product_', '', $markup['key']);
                $token = config('app.baleomol_key');
                $url = config('app.baleomol_url') . '/products/' . $product_id;
                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                ])->get($url);

                $markup_price = floor($response['data']['price'] * $markup['value'] / 100);
                $sell_price = $response['data']['price'] + $markup_price;

                $markup['product_data'] = $response['data'];
                $markup['markup_price'] = $markup_price;
                $markup['sell_price'] = $sell_price;
                $markup['markup_price_formatted'] = number_format($markup_price, 0, ',', '.');
                $markup['sell_price_formatted'] = number_format($sell_price, 0, ',', '.');

                $result[] = $markup;
            }

            $data['data'] = $result;

            return response()->json($data);
        }

        return view('content.markup_product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.markup_product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validation_messages = [
            'product_id.required' => 'Produk wajib dipilih!',
            'product_id.unique' => 'Produk telah ditambahkan sebelumnya, silakan pilih produk lain',
            'markup_product.required' => 'Persentase markup harga produk wajib diisi!',
            'markup_product.integer' => 'Persentase harus berupa integer (angka bulat) tanpa koma',
            'markup_product.min' => 'Persentase markup harga minimal 0% (sesuai harga asli)',
            'markup_product.max' => 'Persentase markup harga maksimal 1000%',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'product_id' => [
                    'required',
                    'integer',
                    'min:1',
                ],
                'markup_product' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:1000',
                ]
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $key = "markup_product_{$request->product_id}";

        $new_data = [
            'key' => $key,
            'value' => $request->markup_product,
        ];
        $markup_product = $this->repository->create($new_data);

        if ($markup_product) {
            return redirect()
                ->route('markup_product.index')
                ->with([
                    'success' => 'Berhasil menambah data baru markup produk.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat menambah data. Silakan coba lagi!'
                ]);
        }
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
        $markup_product = $this->repository->getDataById($id);

        if ($markup_product) {
            $product_id = str_replace('markup_product_', '', $markup_product['key']);
            $token = config('app.baleomol_key');
            $url = config('app.baleomol_url') . '/products/' . $product_id;
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get($url);
    
            $real_product = $response['data'];
    
            return view(
                'content.markup_product.edit',
                compact('markup_product', 'real_product'),
            );
        } else {
            return redirect()
                ->route('markup_product.index')
                ->with([
                    'error' => "Gagal mengedit data - data markup produk dengan id {$id} tidak ditemukan.",
                ]);
        }        
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
        $validation_messages = [
            'product_id.required' => 'Produk wajib dipilih!',
            'product_id.unique' => 'Produk telah ditambahkan sebelumnya, silakan pilih produk lain',
            'markup_product.required' => 'Persentase markup harga produk wajib diisi!',
            'markup_product.integer' => 'Persentase harus berupa integer (angka bulat) tanpa koma',
            'markup_product.min' => 'Persentase markup harga minimal 0% (sesuai harga asli)',
            'markup_product.max' => 'Persentase markup harga maksimal 1000%',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'product_id' => [
                    'required',
                    'integer',
                    'min:1',
                ],
                'markup_product' => [
                    'required',
                    'integer',
                    'min:0',
                    'max:1000',
                ]
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $key = "markup_product_{$request->product_id}";

        $new_data = [
            'key' => $key,
            'value' => $request->markup_product,
        ];
        $markup_product = $this->repository->update($id, $new_data);

        if ($markup_product) {
            return redirect()
                ->route('markup_product.index')
                ->with([
                    'success' => 'Berhasil memperbarui data markup produk.'
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
