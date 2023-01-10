<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\SupplierNonActive;
use App\Http\Controllers\Controller;
use App\Repositories\Supplier\SupplierNonActiveRepository;

class SupplierNonactiveController extends Controller
{
    protected $supplierNonActiveRepository;

    public function __construct(SupplierNonActiveRepository $supplierNonActiveRepository)
    {
        $this->supplierNonActiveRepository = $supplierNonActiveRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->supplierNonActiveRepository->getDataTable($request);
        }
        return view('suppliers.nonactive.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.nonactive.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'supplier_id' => [
                'required',
                'numeric',
                'min:1',
                Rule::unique('supplier_inactives', 'origin_supplier_id')
                    ->whereNull('deleted_at')
            ]
        ]);

        $results= SupplierNonActive::create([
            'origin_supplier_id' => $request->supplier_id,
            'username' => $request->origin_supplier_username,
            'store_name' => $request->origin_supplier_store_name,
            'image_url' => $request->image_url,
        ]);

        if ($results) {
            return redirect()
                ->route('suppliers.nonactive.index')
                ->with([
                    'success' => 'Berhasil menambah data baru supplier tidak aktif.'
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
        $delete = $this->supplierNonActiveRepository->delete($id);

        if ($delete) {
            return redirect()->route('suppliers.nonactive.index')
                ->with('success', 'Data Supplier yang nonactive telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data supplier yang nonactive');
        }
    }
}
