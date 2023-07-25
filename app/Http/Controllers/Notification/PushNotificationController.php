<?php

namespace App\Http\Controllers\Notification;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use App\Repositories\Content\PushNotificationsRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PushNotificationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $pushNotificationsRepository;

public function __construct(PushNotificationsRepository $pushNotificationsRepository)
{
    $this->pushNotificationsRepository = $pushNotificationsRepository;    
}

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->pushNotificationsRepository->getDataTable($request);
        }
        return view('content.pushnotification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('content.pushnotification.create');
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
            'description.required' => 'Deskripsi tidak boleh kosong',
            'url.required' => 'URL tidak boleh terlalu panjang',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:64',
            'description' => 'required',
            'url' => 'max:144'
        ], $messages);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $title = $request->title;
        $description = $request->description;
        $url = $request->url ?? '-';

        $createData = [
            'title' => $title,
            'description' => $description,
            'url' => $url ?? '',
        ];

        $result = $this->pushNotificationsRepository->create($createData);
        if ($result) {
            return redirect()->route('pushnotification.index')
                ->with('success', 'Push Notification telah berhasill dibuat');
        } else {
            return back()->withInput() - with('info', 'Gagal membuat data Push Notification');
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
        $data = PushNotification::findorfail($id);
        return view('content.pushnotification.show', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = PushNotification::findorfail($id);
        return view('content.pushnotification.edit', compact('data'));
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
            'title.required' => 'Title Notifications tidak boleh kosong',
            'description.required' => 'Deskripsi Notifikasi tidak boleh kosong',
            'url.required' => 'URL Notifications tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'title' => 'required|max:64',
            'description' => 'required',
            'url' => 'max:144'
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $updateData = [
            'title' => $request->title,
            'description' => $request->description,
            'url' => $request->url,
        ];



        $result = $this->pushNotificationsRepository->update($id, $updateData);

        if ($result) {
            return redirect()->route('pushnotification.index')->with('success', 'Data Push Notification Berhasil Diubah');
        } else {
            return back()->withInput()->with('Info', 'Gagal mengubah Push Notification');
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
        $delete = $this->pushNotificationsRepository->delete($id);
        if ($delete) {
            return redirect()->route('pushnotification.index')->with('success', 'Data Push Notification Berhasil Dihapus.');
        } else {
            return back()->withInput()->with('Info', 'Gagal menghapus data Push Notification');
        }
    }
}
