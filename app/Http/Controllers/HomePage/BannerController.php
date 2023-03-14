<?php

namespace App\Http\Controllers\HomePage;

use App\Models\Banner;
use Illuminate\Http\Request;
use App\Models\BannerCategory;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Content\Banner\BannerRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    private $bannerRepository;

    public function __construct(BannerRepository $bannerRepository)
    {
        $this->bannerRepository = $bannerRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->bannerRepository->getDataTable($request);
        }

        return view('content.banners.banner.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $bannerCategories = BannerCategory::get();

        return view('content.banners.banner.create', compact(['bannerCategories']));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        // exit;
        $messages = [
            'name.required' => 'Nama tidak boleh kosong',
            'number.required' => 'Nomor Handphone tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'type' => 'required',
            'target_url' => 'required|max:255',
            'position' => 'required',
            'thumbnail_image' => 'required|sometimes|mimes:jpg,png,jpeg,gif|max:1024',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $type = $request->type;
        $position = $request->position;
        $name = $request->name;
        $target_url = $request->target_url ?? '';
        $description = $request->description ?? '';

        $createData = [
            'banner_category_id' => 0,
            'position' => $position,
            'type' => $type,
            'name' => $name,
            'target_url' => $target_url,
            'description' => $description,
        ];

        $thumbnailImage = $request->file('thumbnail_image');

        if ($thumbnailImage) {
            $fileName = 'thumbnail_' . time() . '_' . uniqid() . '_' . $thumbnailImage->getClientOriginalName();
            $thumbnailImage->move(public_path('storage/banners/thumbnail/'), $fileName);
            $path_file = 'storage/system_storage/banners/thumbnail/' . $fileName;
            $createData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/banners/thumbnail/') . $fileName));
        }

        $result = $this->bannerRepository->create($createData);

        if ($result) {
            return redirect()->route('banners.index')
                ->with('success', 'Data Banner telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data banner');
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
        $bannerCategories = BannerCategory::get();
        $data = $this->bannerRepository->getDataById($id);

        return view('content.banners.banner.show', compact(['data', 'bannerCategories']));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bannerCategories = BannerCategory::get();
        $data = $this->bannerRepository->getDataById($id);
        $productData = [];
        $supplierData = [];

        $token = config('app.baleomol_key');

        if ($data->type == 'store') {
            $url = config('app.baleomol_url') . '/suppliers/' . $data->target_url;
            $response = Http::withHeaders(['Authorization' => "Bearer {$token}"])->get($url);
            $supplierData = $response['data'];
        }

        if ($data->type == 'product') {
            $url = config('app.baleomol_url') . '/products/' . $data->target_url;
            $response = Http::withHeaders(['Authorization' => "Bearer {$token}"])->get($url);
            $productData = $response['data'];
        }

        return view('content.banners.banner.edit', compact([
            'data',
            'bannerCategories',
            'productData',
            'supplierData',
        ]));
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
            'name.unique' => 'Nama sudah digunakan',
            'number.required' => 'Nomor Handphone tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'type' => 'required',
            'target_url' => 'required|max:255',
            'position' => 'required',
            'description' => 'max:255',
            'thumbnail_image' => 'required|sometimes|mimes:jpg,png,jpeg,gif|max:1024',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $type = $request->type;
        $position = $request->position;
        $name = $request->name;
        $target_url = $request->target_url ?? '';
        $description = $request->description ?? '';

        $updateData = [
            'banner_category_id' => 0,
            'position' => $position,
            'type' => $type,
            'name' => $name,
            'target_url' => $target_url,
            'description' => $description,
        ];

        $thumbnailImage = $request->file('thumbnail_image');

        if ($thumbnailImage) {
            $banner = $this->bannerRepository->getDataById($id);
            $imagePath = public_path('storage/' . $banner->image);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }

            $fileName = 'thumbnail_' . time() . '_' . uniqid() . '_' . $thumbnailImage->getClientOriginalName();
            $thumbnailImage->move(public_path('storage/banners/thumbnail/'), $fileName);
            $path_file = 'storage/system_storage/banners/thumbnail/' . $fileName;
            $updateData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/banners/thumbnail/') . $fileName));
        }

        $result = $this->bannerRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('banners.edit', $id)
                ->with('success', 'Data Banner telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data banner');
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
        $delete = $this->bannerRepository->delete($id);

        if ($delete) {
            return redirect()->route('banners.index')
                ->with('success', 'Data Banner telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data banner');
        }
    }
}
