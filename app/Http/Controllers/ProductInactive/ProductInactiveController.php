<?php

namespace App\Http\Controllers\ProductInactive;

use App\Http\Controllers\Controller;
use App\Models\ProductInactive;
use App\Repositories\ProductInactive\ProductInactiveRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductInactiveController extends Controller
{
    protected $repository;

    public function __construct(ProductInactiveRepository $productInactiveRepository)
    {
        $this->repository = $productInactiveRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        if ($request->ajax()) {
            $data = $this->repository->getDataTable($request);

            return response()->json($data);
        }

        return view('product_inactive.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('product_inactive.create');
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
            'origin_product_id.required' => 'Produk wajib dipilih!',
            'origin_product_id.unique' => 'Produk telah ditambahkan sebelumnya, silakan pilih produk lain!',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'origin_product_id' => [
                    'required',
                    'numeric',
                    'min:1',
                    'unique:product_inactives,origin_product_id'
                ],
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $productInactive = ProductInactive::create([
            'origin_product_id' => $request->origin_product_id,
            'origin_supplier_id' => $request->origin_supplier_id,
            'origin_supplier_username' => $request->origin_supplier_username,
            'name' => $request->origin_product_name,
            'image_url' => $request->origin_product_image_url,
        ]);

        if ($productInactive) {
            return redirect()
                ->route('product_inactive.index')
                ->with([
                    'success' => 'Berhasil menambah data baru produk non aktif.'
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
        //
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
        try {
            $data = ProductInactive::findOrFail($id);

            if (!$data) {
                throw new Exception("Data produk dengan id {$id} tidak ditemukan atau telah dihapus");
            }

            $response_data = $data;

            if ($data->delete()) {
                return redirect()
                    ->route('product_inactive.index')
                    ->with([
                        'success' => 'Berhasil menghapus data produk nonaktif.'
                    ]);
            } else {
                return redirect()
                    ->route('product_inactive.index')
                    ->with([
                        'error' => "Gagal menghapus data - Produk nonaktif dengan nama {$response_data->name} tidak ditemukan.",
                    ]);
            }
        } catch (Exception $err) {
            return redirect()
                ->route('video_tutorials.index')
                ->with([
                    'error' => "Gagal menghapus data - Produk nonaktif dengan nama {$response_data->name} tidak ditemukan.",
                ]);
        }
    }
}
