<?php

namespace App\Http\Controllers\HomePage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\CsNumber;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\Content\CS\CsNumberCategoryRepositoryInterface;

class CsNumberCategoryController extends Controller
{
    private $csCategoryRepository;

    public function __construct(CsNumberCategoryRepositoryInterface $csCategoryRepository)
    {
        $this->csCategoryRepository = $csCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->csCategoryRepository->getDataTable($request);
        }

        return view('content.cs_numbers.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.cs_numbers.category.create');
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
            'name.required' => 'Nama tidak boleh kosong',
            'name.unique' => 'Nama kategori sudah digunakan',
            'code.required' => 'Tipe tidak boleh kosong',
            'code.unique' => 'Tipe kategori sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'code' => 'required|unique:cs_number_categories,code|max:64',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $createData = [
            'name' => $request->name,
            'code' => $request->code,
        ];

        $result = $this->csCategoryRepository->create($createData);

        if ($result) {
            return redirect()->route('cs-number.category.index')
                ->with('success', 'Data Kategori Nomor CS telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data kategori nomor cs');
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
        $data = $this->csCategoryRepository->getDataById($id);
        return view('content.cs_numbers.category.show', compact(['data']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->csCategoryRepository->getDataById($id);
        return view('content.cs_numbers.category.edit', compact(['data']));
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
            'name.required' => 'Nama tidak boleh kosong',
            'name.unique' => 'Nama kategori sudah digunakan',
            'code.required' => 'Tipe tidak boleh kosong',
            'code.unique' => 'Tipe kategori sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'code' => 'required|unique:cs_number_categories,code|max:64',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'code' => $request->code,
        ];

        $result = $this->csCategoryRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('cs-number.category.edit',$id)
                ->with('success', 'Data Kategori Nomor CS telah berhasil diubah.');
        } else {
            return back()->withInput()->with('info', 'Gagal memperbaharui data kategori nomor cs');
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
        $delete = $this->csCategoryRepository->delete($id);

        $csNumbers = CsNumber::where('cs_category_id',$id)->get();

        foreach ($csNumbers as $key => $value) {
            CsNumber::where('id', $value->id)->forcedelete();
        }

        if ($delete) {
            return redirect()->route('cs-number.category.index')
                ->with('success', 'Data Kategori Nomor CS telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data kategori nomor cs');
        }
    }
}
