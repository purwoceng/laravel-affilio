<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\SupplierHome;
use App\Repositories\HomePage\SupplierRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Rule;

class SupplierController extends Controller
{
    protected $supplier_repository;

    public function __construct(SupplierRepository $supplier_repository)
    {
        $this->supplier_repository = $supplier_repository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->supplier_repository
                ->getDataTable($request);

            $suppliers = $data['data'];

            $result = [];

            foreach ($suppliers as $supplier) {
                $token = config('app.baleomol_key');
                $url = config('app.baleomol_url') . '/suppliers/' . $supplier['supplier_id'];

                $response = Http::withHeaders([
                    'Authorization' => "Bearer {$token}",
                ])->get($url);

                $supplier['supplier_data'] = $response['data'];

                $result[] = $supplier;
            }

            $data['data'] = $result;

            return response()->json($data);
        }

        return view('content.supplier_home.index');
    }

    public function create()
    {
        $arr_range = range(1, 50);
        $data = SupplierHome::whereNull('deleted_at')->get();

        $exists_numbers = array_map(function($supplier) {
            return $supplier->queue_number;
        }, json_decode(json_encode($data, true)));

        $available_numbers = array_filter(
            $arr_range,
            function($number) use ($exists_numbers) {
                if (in_array($number, $exists_numbers)) return false;
                return true;
            }
        );

        return view('content.supplier_home.create', compact('available_numbers'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'supplier_id' => [
                'required',
                'numeric',
                'min:1',
                Rule::unique('supplier_home', 'supplier_id')
                    ->whereNull('deleted_at')
            ],
            'queue_number' => ['required', 'numeric', 'min:1', 'max:100'],
        ]);

        $supplier_home = SupplierHome::create([
            'supplier_id' => $request->supplier_id,
            'queue_number' => $request->queue_number,
            'supplier_home_type_id' => 1,
            'is_active' => '1',
            'redis_key' => '',
        ]);

        if ($supplier_home) {
            return redirect()
                ->route('supplier_home.index')
                ->with([
                    'success' => 'Berhasil menambah data baru supplier rekomendasi.'
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
        $supplier = SupplierHome::findOrFail($id);

        if ($supplier) {
            $arr_range = range(1, 50);
            $data = SupplierHome::where('id', '!=' , $id)->whereNull('deleted_at')->get();
    
            $exists_numbers = array_map(function($supplier) {
                return $supplier->queue_number;
            }, json_decode(json_encode($data, true)));
    
            $available_numbers = array_filter(
                $arr_range,
                function($number) use ($exists_numbers) {
                    if (in_array($number, $exists_numbers)) return false;
                    return true;
                }
            );
    
            $token = config('app.baleomol_key');
            $url = config('app.baleomol_url') . '/suppliers/' . $supplier['supplier_id'];
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$token}",
            ])->get($url);
    
            $real_supplier = $response['data'];
    
            return view(
                'content.supplier_home.edit',
                compact('supplier', 'available_numbers', 'real_supplier'),
            );
        } else {
            return redirect()
                ->route('supplier_home.index')
                ->with([
                    'error' => "Gagal mengedit data - supplier rekomendasi dengan id {$id} tidak ditemukan.",
                ]);
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'supplier_id' => [
                'required',
                'numeric',
                'min:1',
                Rule::unique('supplier_home', 'supplier_id')
                    ->ignore($id)
                    ->whereNull('deleted_at'),
            ],
            'queue_number' => 'required|numeric|min:1|max:100',
        ]);

        $supplier = SupplierHome::findOrFail($id);
        $supplier->supplier_id = $request->supplier_id;
        $supplier->queue_number = $request->queue_number;
        $supplier->is_active = $request->is_active;
        $supplier->save();

        if ($supplier) {
            return redirect()
                ->route('supplier_home.index')
                ->with([
                    'success' => 'Berhasil mengedit data supplier rekomendasi.'
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

        $arr_range = range(1, 50);

        $data = SupplierHome::where('id', '!=', $exception_id)->where('is_active', 1)->get();

        $exists_numbers = array_map(function($product) {
            return $product->queue_number;
        }, json_decode(json_encode($data, true)));

        $available_numbers = array_filter(
            $arr_range,
            function($number) use ($exists_numbers) {
                if (in_array($number, $exists_numbers)) return false;
                return true;
            }
        );

        return response()->json(['available_numbers' => array_values($available_numbers)]);
    }

    public function delete($id)
    {
        $supplier = SupplierHome::find($id);
        
        if ($supplier) {
            $supplier->is_active = '0';
            $supplier->save();
    
            $supplier->delete();
     
            return redirect()
                ->route('supplier_home.index')
                ->with([
                    'success' => 'Berhasil menghapus data supplier rekomendasi.'
                ]);
        } else {
            return redirect()
                ->route('supplier_home.index')
                ->with([
                    'error' => "Gagal menghapus data - supplier rekomendasi dengan id {$id} tidak ditemukan.",
                ]);
        }
    }
}
