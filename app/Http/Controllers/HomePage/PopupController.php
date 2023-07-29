<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use App\Models\Popup;
use App\Repositories\Funnellink\PopupRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PopupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
protected $popupRepository;

public function __construct(PopupRepository $popupRepository)
{
    $this->popupRepository = $popupRepository;
}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->popupRepository->getDataTable($request);
        }
        return view('content.popup.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.popup.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $massages = [
            'title.required' => 'Title tidak boleh kosong',
            'image.required' => 'Gambar tidak boleh kosong',
            'url.required' => 'URL terlalu panjang',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'image' => 'required|sometimes|mimes:jpg,png,jpeg,gif|max:1024',
            'url' => 'max:255'
        ], $massages);

        if ($validator->fails()){
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $title = $request->title;
        // $image = $request->image;
        $url = $request->url ?? '-';

        $createData = [
            'title' => $title,
            // 'image' => $image,
            'url' => $url,
        ];

$image = $request->file('image');

if ($image){
    $fileName = 'image_' . time() . '_' . uniqid() . $image->getClientOriginalName();
    $image->move(public_path('storage/popup/image/'), $fileName);
    $path_file = 'storage/system_storage/popup/image/' . $fileName;
    $createData['image'] = $path_file;
    Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/popup/image/') . $fileName));
}

        $result = $this->popupRepository->create($createData);

        if($result) {
            return redirect()->route('popup.index')
            ->with('success', 'Popup Notification telah berhasil dibuat');
        } else {
            return back()->withInput() - with('info', 'Gagal membuat data Popup Notification');
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
        $data = Popup::findorfail($id);
        return view('content.popup.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Popup::findorfail($id);
        return view('content.popup.edit', compact('data'));
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
        $massages = [
            'title.required' => 'Title Popup tidak boleh kosong',
            'image.required' => 'Image Popup wajib diisi',
            'url.required' => 'URL Popup terlalu panjang',
            
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:64',
            'URL' => 'max:144',
            'image' => 'required|sometimes|mimes:jpg,png,jpeg,gif|max:1024'
        ], $massages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

$title = $request->title;
$url = $request->url ?? '';

        $updateData = [
            'title' => $title,
            // 'image' => $image,
            'url' => $url,
        ];

        $image = $request->file('image');

        if ($image) {
            $popup = $this->popupRepository->getPopupById($id);
            $imagePath = public_path('storage/' . $popup->image);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }

            $fileName = 'image_' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/popup/image/'), $fileName);
            $path_file = 'storage/system_storage/popup/image/' . $fileName;
            $updateData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/popup/image/') . $fileName));
        }

        $result = $this->popupRepository->update($id, $updateData);

        if ($result){
            return redirect()->route('popup.index')->with('success', 'Data Popup Berhasil Diubah');
        } else {
            return back()->withInput()->with('Info', 'Gagal mengubah Popup Notification');
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
        $delete = $this->popupRepository->delete($id);
        if ($delete) {
            return redirect()->route('popup.index')->with('success', 'Data Popup Berhasil dihapus');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data Popup');
        }
    }
}
