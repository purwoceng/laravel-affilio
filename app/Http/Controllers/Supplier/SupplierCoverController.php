<?php

namespace App\Http\Controllers\Supplier;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SupplierCover;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Supplier\SupplierCoverRepository;

class SupplierCoverController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $SupplierCoverRepository;

    public function __construct(SupplierCoverRepository $SupplierCoverRepository)
    {
        $this->SupplierCoverRepository = $SupplierCoverRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->SupplierCoverRepository->getDataTable($request);
        }
        return view ('suppliers.cover.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('suppliers.cover.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $messages = [
            'image.required' => 'Gambar tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(),[

        ], $messages);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $createData = [
            'is_active' => '1',
        ];

        $image = $request->file('image');

        if($image) {
            $filename = 'Image-' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/suppliercover/thumbnail/'), $filename);
            $path_file = 'storage/system_storage/suppliercover/thumbnail/' . $filename;
            $createData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/suppliercover/thumbnail/') . $filename));

        }

        $result = $this->SupplierCoverRepository->create($createData);

        if ($result){
            return redirect()->route('supplierscover.index')->with('success', 'Data Background Cover supplier Berhasil Dibuat');
        }else{
            return back()->withInput()->with('Info', 'Gagal membuat data Background Cover supplier');
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
        $data = SupplierCover::findorfail($id);
        return view('suppliers.cover.show',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = SupplierCover::findorfail($id);
        return view('suppliers.cover.edit',compact('data'));
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
        $messages = [
            'image.required' => 'Gambar tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(),[

        ], $messages);

        if($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'is_active' => $request->is_active,
        ];

        $image = $request->file('image');

        if($image) {
            $filename = 'Image-' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/suppliercover/thumbnail/'), $filename);
            $path_file = 'storage/system_storage/suppliercover/thumbnail/' . $filename;
            $updateData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/suppliercover/thumbnail/') . $filename));

        }

        $result = $this->SupplierCoverRepository->update($id,$updateData);

        if ($result){
            return redirect()->route('supplierscover.index')->with('success', 'Data Background Cover supplier Berhasil Dibuat');
        }else{
            return back()->withInput()->with('Info', 'Gagal membuat data Background Cover supplier');
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
        $delete = $this->SupplierCoverRepository->delete($id);
        if($delete){
            return redirect()->route('supplierscover.index')->with('success', 'Data Gambar Supplier Berhasil Dihapus.');
        }else{
            return back()->withInput()->with('Info', 'Gagal menghapus data Gambar Supplier');
        }
    }
}
