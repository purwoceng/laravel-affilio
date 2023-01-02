<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\Category\CategoryRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $category_repository;

    
    public function __construct(CategoryRepository $category_repository)
    {
        $this->category_repository = $category_repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = $this->category_repository
                ->getDataTable($request);

            return response()->json($data);
        }

        return view('content.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $token = config('app.baleomol_key');
        $url = config('app.baleomol_url') . '/categories';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get($url);

        $categories = $response['data'] ?? [];

        return view('content.categories.create', compact('categories'));
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
            'name.required' => 'Nama kategori wajib diisi!',
            'origin_category_id.required' => 'Kategori Baleomol wajib dipilih!',
            'origin_category_id.exists' => 'Kategori sudah ada atau pernah ditambahkan sebelumnya!',
            'image.required' => 'Gambar wajib diisi!',
            'image.image' => 'File yang diinput wajib gambar!',
            'image.mimes' => 'Gambar yang diinput wajib berformat PNG atau JPEG!',
            'image.max' => 'Gambar maksimal berukuran 2MB!',
            'image.dimensions' => 'Resolusi gambar maksimal 1000 pixel!',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'origin_category_id' => [
                    'required',
                    Rule::unique('categories', 'origin_category_id')->whereNull('deleted_at'),
                ],
                'image' => [
                    'required',
                    'image',
                    'mimes:jpg,png,jpeg',
                    'max:2048',
                    'dimensions:max_width=1000,max_height=1000',
                ],
                'description' => ['max:255']
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $link = preg_replace('/[^A-Za-z0-9\s]/', ' ', strtolower($request->name));
        $link = preg_replace('/\s+/', ' ', $link);
        $link = str_replace(' ', '-', $link);

        $category_data = [
            'name' => $request->name,
            'origin_category_id' => $request->origin_category_id,
            'link' => $link,
            'description' => $request->description,
            'image' => '',
        ];

        $image = $request->file('image');

        if ($image) {
            $new_file_name = 'thumbnail_' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/category/'), $new_file_name);
            $category_data['image'] = "category/" . $new_file_name;
        }

        $category = Category::create($category_data);

        if ($category) {
            return redirect()
                ->route('categories.index')
                ->with([
                    'success' => 'Berhasil menambah data kategori baru.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat menambah data. Mohon coba kembali!'
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
        $category = Category::findOrFail($id);
        $token = config('app.baleomol_key');
        $url = config('app.baleomol_url') . '/categories';
        $response = Http::withHeaders([
            'Authorization' => "Bearer {$token}",
        ])->get($url);

        $categories = $response['data'] ?? [];

        return view('content.categories.edit', compact('categories', 'category'));
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
            'name.required' => 'Nama kategori wajib diisi!',
            'origin_category_id.required' => 'Kategori Baleomol wajib dipilih!',
            'origin_category_id.exists' => 'Kategori sudah ada atau pernah ditambahkan sebelumnya!',
            'image.image' => 'File yang diinput wajib gambar!',
            'image.mimes' => 'Gambar yang diinput wajib berformat PNG atau JPEG!',
            'image.max' => 'Gambar maksimal berukuran 2MB!',
            'image.dimensions' => 'Resolusi gambar maksimal 1000 pixel!',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => ['required'],
                'origin_category_id' => [
                    'required',
                    Rule::unique('categories', 'origin_category_id')
                        ->ignore($id)
                        ->whereNull('deleted_at'),
                ],
                'image' => [
                    'image',
                    'mimes:jpg,png,jpeg',
                    'max:2048',
                    'dimensions:max_width=1000,max_height=1000',
                ],
                'description' => ['max:255']
            ],
            $validation_messages,
        );

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $link = preg_replace('/[^A-Za-z0-9\s]/', ' ', strtolower($request->name));
        $link = preg_replace('/\s+/', ' ', $link);
        $link = str_replace(' ', '-', $link);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->link = $link;
        $category->origin_category_id = $request->origin_category_id;
        $category->description = $request->description;

        $image = $request->file('image');

        if ($image) {
            $new_file_name = 'thumbnail_' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/category/'), $new_file_name);
            $category->image = "category/" . $new_file_name;
        }

        $category->save();

        if ($category) {
            return redirect()
                ->route('categories.index')
                ->with([
                    'success' => 'Berhasil memperbarui data kategori.'
                ]);
        } else {
            return redirect()
                ->back()
                ->withInput()
                ->with([
                    'error' => 'Terjadi kesalahan saat memperbarui data. Mohon coba kembali!'
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
        try {
            $data = Category::findOrFail($id);

            if (!$data) {
                throw new Exception("Data kategori dengan id {$id} tidak ditemukan atau telah dihapus");
            }
            
            $response_data = $data;

            if ($data->delete()) {
                return redirect()
                    ->route('categories.index')
                    ->with([
                        'success' => "Berhasil menghapus data produk kategori {$response_data->name}."
                    ]);
            } else {
                return redirect()
                    ->route('categories.index')
                    ->with([
                        'error' => "Gagal menghapus data - kategori dengan id {$id} tidak ditemukan.",
                    ]);
            }
        } catch (Exception $err) {
            return redirect()
                ->route('categories.index')
                ->with([
                    'error' => "Gagal menghapus data - kategori dengan id {$id} tidak ditemukan.",
                ]);
        }
    }
}
