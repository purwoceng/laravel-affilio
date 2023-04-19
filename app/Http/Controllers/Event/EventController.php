<?php

namespace App\Http\Controllers\Event;

use App\Models\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Event\EventRepository;

class EventController extends Controller
{
    private $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->eventRepository->getDataTable($request);
        }

        return view('events.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('events.create');
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

        $validation_massages = [
            'name.required' => 'Judul Tidak Boleh Kosong',
        ];

        $validator = Validator::make(
            $request->all(),
            [
                'name' => 'required|max:64',
                'speaker' => 'required',
                'price' => 'required',
                'tiket' => 'required',
                'kuota' => 'required',
                'time' => 'required',
                'date' => 'required',
                'location' => 'required',
                'prefix' => 'required',
                'image' => 'required|sometimes|mimes:jpg,png,jpeg,gif|max:1024',
                'video' => 'required',
                'type' => 'required',
                'sorting' => 'required',
                'description' => 'required',
                'status' => 'required',
            ],
            $validation_massages
        );

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $speaker = $request->speaker ?? '';
        $price = $request->price ?? '';
        $tiket = $request->tiket ?? '';
        $kuota = $request->kuota ?? '';
        $time = $request->time ?? '';
        $date = $request->date ?? '';
        $location = $request->location ?? '';
        $prefix = $request->prefix ?? '';
        $video = $request->video ?? '';
        $type = $request->type;
        $sorting = $request->sorting ?? '';
        $description = $request->description ?? '';
        $status = $request->status ?? '';

        $createData = [
            'name' => $name,
            'speaker' => $speaker,
            'price' => $price,
            'tiket' => $tiket,
            'kuota' => $kuota,
            'time' => $time,
            'date' => $date,
            'location' => $location,
            'prefix' => $prefix,
            'video' => $video,
            'type' => $type,
            'sorting' => $sorting,
            'description' => $description,
            'status' => $status,
        ];

        $image = $request->file('image');

        if ($image) {
            $fileName = 'image_' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/event/thumbnail/'), $fileName);
            $path_file = 'storage/system_storage/event/thumbnail/' . $fileName;
            $createData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/event/thumbnail/') . $fileName));
        }



        $result = $this->eventRepository->create($createData);

        if ($result) {
            return redirect()->route('event.index')
                ->with('success', 'Data event berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data');
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
        $data = $this->eventRepository->getDataById($id);
        return view('events.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->eventRepository->getDataById($id);
        return view('events.edit', compact([
            'data'
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
            'sorting' => 'urutan harus berbeda',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:64',
            'speaker' => 'required',
            'price' => 'required',
            'tiket' => 'required',
            'kuota' => 'required',
            'time' => 'required',
            'date' => 'required',
            'location' => 'required',
            'prefix' => 'required',
            'image' => 'required|sometimes|mimes:jpg,png,jpeg,gif|max:1024',
            'video' => 'required',
            'type' => 'required',
            'sorting' => 'required',
            'description' => 'max:255',
            'status' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $name = $request->name;
        $speaker = $request->speaker ?? '';
        $price = $request->price ?? '';
        $tiket = $request->tiket ?? '';
        $kuota = $request->kuota ?? '';
        $time = $request->time ?? '';
        $date = $request->date ?? '';
        $location = $request->location ?? '';
        $prefix = $request->prefix ?? '';
        $video = $request->video ?? '';
        $type = $request->type;
        $sorting = $request->sorting ?? '';
        $description = $request->description ?? '';
        $status = $request->status ?? '';

        $updateData = [

            'name' => $name,
            'speaker' => $speaker,
            'price' => $price,
            'tiket' => $tiket,
            'kuota' => $kuota,
            'time' => $time,
            'date' => $date,
            'location' => $location,
            'prefix' => $prefix,
            'video' => $video,
            'type' => $type,
            'sorting' => $sorting,
            'description' => $description,
            'status' => $status,
        ];

        $image = $request->file('image');

        if ($image) {
            $event = $this->eventRepository->getDataById($id);
            $imagePath = public_path('storage/' . $event->image);
            if (File::exists($imagePath)) {
                unlink($imagePath);
            }

            $fileName = 'image_' . time() . '_' . uniqid() . '_' . $image->getClientOriginalName();
            $image->move(public_path('storage/event/thumbnail/'), $fileName);
            $path_file = 'storage/system_storage/event/thumbnail/' . $fileName;
            $updateData['image'] = $path_file;
            Storage::disk('s3')->put($path_file, file_get_contents(public_path('storage/event/thumbnail/') . $fileName));
        }


        $result = $this->eventRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('event.edit', $id)
                ->with('success', 'Data Event telah berhasil diubah');
        } else {
            return back()->withInput()->with('info', 'Gagal mengubah data event');
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
        $delete = $this->eventRepository->delete($id);

        if ($delete) {
            return redirect()->route('event.index')
                ->with('success', 'Data Event telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data event');
        }
    }
}
