<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Repositories\Event\EventGreetingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class EventGreetingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $EventGreetingRepository;

    public function __construct(EventGreetingRepository $EventGreetingRepository)
    {
        $this->EventGreetingRepository = $EventGreetingRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->EventGreetingRepository->getDataTable($request);
        }
        return view('greetings.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('greetings.create');
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
        $url_regex = '/((http|https)\:\/\/)?[a-zA-Z0-9\.\/\?\:@\-_=#]+\.([a-zA-Z0-9\&\.\/\?\:@\-_=#])*/';
        $messages = [
            'title.required' => 'Judul tidak boleh kosong',
            'thumbnail.required' => 'Thumbnail tidak boleh kosong',
            'timer.required' => 'Timer tidak boleh kosong',
            'url.regex' => 'Url tidak boleh kosong',
            'is_active.required' => 'Status tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'thumbnail' => 'required|sometimes|mimes:jpg,png,jpeg,gif|max:1024',
            'timer' => 'required',
            'url' => 'required',
            'is_active' => 'required',
            'file' => [
                "regex:{$url_regex}",
                'string',
            ],

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $title = $request->title;
        $timer = $request->timer;
        $url = $request->url;
        $is_active = $request->is_active;

        $createData = [
            'title' => $title,
            'timer' => $timer,
            'url' => $url,
            'is_active' => $is_active,
        ];

        $thumbnail = $request->file('thumbnail');

        if ($thumbnail) {
            $fileName = 'thumbnail_' . time() . '_' . uniqid() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('storage/greeting/thumbnail/'), $fileName);
            $path_file = 'storage/system_storage/greeting/thumbnail/' . $fileName;
            $createData['thumbnail'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/greeting/thumbnail/') . $fileName));
        }

        $result = $this->EventGreetingRepository->create($createData);

        if ($result) {
            return redirect()->route('greeting.index')
                ->with('success', 'Greeting Event telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data Greeting');
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
        $data = $this->EventGreetingRepository->getGreetingById($id);
        return view('greetings.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->EventGreetingRepository->getGreetingById($id);
        return view('greetings.edit', compact('data'));
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
            'title.required' => 'Title tidak boleh kosong',
            'thumbnail.required' => 'Thumbnail tidak boleh kosong',
            'timer.required' => 'Timer tidak boleh kosong',
            'url.required' => 'Url tidak boleh kosong',
            'is_active.required' => 'Status Pesan tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:255',
            'thumbnail' => 'required',
            'timer' => 'required',
            'url' => 'required',
            'is_active' => 'required',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $title = $request->title;
        $thumbnail = $request->thumbnail;
        $timer = $request->timer;
        $url = $request->url;
        $is_active = $request->is_active;

        $updateData = [
            'title' => $title,
            'thumbnail' => $thumbnail,
            'timer' => $timer,
            'url' => $url,
            'is_active' => $is_active,
        ];

        $thumbnail = $request->file('thumbnail');

        if ($thumbnail) {

            $filename = 'Tipe-' . time() . '_' . uniqid() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('storage/greeting/thumbnail/'), $filename);
            $path_file = 'storage/system_storage/greeting/thumbnail/' . $filename;
            $updateData['thumbnail'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/greeting/thumbnail/') . $filename));
        }

        $result = $this->EventGreetingRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('greeting.index')
                ->with('success', 'Greeting telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data greeting');
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
        $delete = $this->EventGreetingRepository->delete($id);

        if ($delete) {
            return redirect()->route('greeting.index')
                ->with('success', 'Data Greeting telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data Greeting');
        }
    }
}
