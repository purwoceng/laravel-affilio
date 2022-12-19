<?php

namespace App\Http\Controllers\HomePage;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Interfaces\Content\Banner\BannerCategoryRepositoryInterface;

class BannerCategoryController extends Controller
{
    private $bannerCategoryRepository;

    public function __construct(BannerCategoryRepositoryInterface $bannerCategoryRepository)
    {
        $this->bannerCategoryRepository = $bannerCategoryRepository;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->bannerCategoryRepository->getDataTable($request);
        }

        return view('content.banners.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.banners.category.create');
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
            'code.required' => 'Tipe tidak boleh kosong',
            'code.unique' => 'Tipe kategori sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'code' => 'required|unique:banner_categories,code|max:64',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $createData = [
            'name' => $request->name,
            'code' => $request->code,
        ];

        $result = $this->bannerCategoryRepository->create($createData);

        if ($result) {
            return redirect()->route('banners.category.index')
                ->with('success', 'Data Kategori Banner telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data kategori banner');
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

        $data = $this->bannerCategoryRepository->getDataById($id);

        return view('content.banners.category.show', compact(['data']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->bannerCategoryRepository->getDataById($id);

        return view('content.banners.category.edit', compact(['data']));
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
            'code.required' => 'Tipe tidak boleh kosong',
            'code.unique' => 'Tipe kategori sudah digunakan',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'code' => 'required|unique:banner_categories,code|max:64',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'name' => $request->name,
            'code' => $request->code,
        ];

        $result = $this->bannerCategoryRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('banners.category.index')
                ->with('success', 'Data Kategori Banner telah berhasil diubah.');
        } else {
            return back()->withInput()->with('info', 'Gagal memperbaharui data kategori banner');
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
        $delete = $this->bannerCategoryRepository->delete($id);

        if ($delete) {
            return redirect()->route('banners.category.index')
                ->with('success', 'Data Kategori Banner telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data kategori banner');
        }
    }
}
