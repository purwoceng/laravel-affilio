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
            'notification.required' => 'Notifikasi tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'notification' => 'required|max:255',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $categories = $request->categories;
        $notification = $request->notification;

        $createData = [
            'categories' => $categories,
            'notification' => $notification,
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
            'notification.required' => 'Notifikasi tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'notification' => 'required|max:255',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $categories = $request->categories;
        $notification = $request->notification;

        $updateData = [
            'categories' => $categories,
            'notification' => $notification,
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
