<?php

namespace App\Http\Controllers\Notification;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Notification\NotificationRepository;

class NotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $NotificationRepository;

    public function __construct(NotificationRepository $NotificationRepository)
    {
        $this->NotificationRepository = $NotificationRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->NotificationRepository->getDataTable($request);
        }
        return view ('notification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view ('notification.create');
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
            'title.required' => 'Title tidak boleh kosong',
            'description.required' => 'Notifikasi tidak boleh kosong',
            'categories.required' => 'Kategori tidak boleh kosong',
            'creator_id.required' => 'Kreator tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'description' => 'required|max:255',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $categories = $request->categories;
        $title = $request->title;
        $description = $request->description;
        $creator_id = $request->creator_id;

        $createData = [
            'categories' => $categories,
            'title' => $title,
            'description' => $description,
            'creator_id' => $creator_id,
        ];

        $result = $this->NotificationRepository->create($createData);

        if ($result) {
            return redirect()->route('notification.index')
                ->with('success', 'Notifikasi telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data notifikasi');
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
        $data = $this->NotificationRepository->getNotificationById($id);
        return view('notification.detail',compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->NotificationRepository->getNotificationById($id);
        return view ('notification.edit',compact('data'));
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
            'description.required' => 'Notifikasi tidak boleh kosong',
            'categories.required' => 'Kategori tidak boleh kosong',
            'creator_id.required' => 'Kreator Pesan tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'description' => 'required|max:255',
            'categories' => 'required|max:255',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $categories = $request->categories;
        $title = $request->title;
        $description = $request->description;
        $creator_id = $request->creator_id;

        $updateData = [
            'categories' => $categories,
            'title' => $title,
            'description' => $description,
            'creator_id' => $creator_id,
        ];

        $result = $this->NotificationRepository->update($id,$updateData);

        if ($result) {
            return redirect()->route('notification.index')
                ->with('success', 'Notifikasi telah berhasil dibuat');
        } else {
            return back()->withInput()->with('info', 'Gagal membuat data notifikasi');
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
        $delete = $this->NotificationRepository->delete($id);

        if ($delete) {
            return redirect()->route('notification.index')
                ->with('success', 'Data Video Home Fitur Panel telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data kategori Video Home Fitur Panel');
        }
    }
}
