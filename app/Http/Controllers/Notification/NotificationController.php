<?php

namespace App\Http\Controllers\Notification;

use App\Models\MemberType;
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
            $result = $this->NotificationRepository->getDataTable($request);
            $data = array_map(function ($item) {
                $member_type = MemberType::where('id', $item['member_type_id'])->first();
                $new_item = array_merge($item, [
                    'member_type_id' => $member_type->type ?? '-',
                ]);
                return $new_item;
            }, $result['data']);
            $result['data'] = $data;

            return response()->json($result);
        }
        return view('notification.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $member_types = MemberType::whereNull('deleted_at')->get();
        return view('notification.create', compact('member_types'));
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
            'member_type_id.required' => 'Tipe Mmber tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'description' => 'required|max:255',
            'member_type_id' => 'required',
            'title' => 'required',

        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $member_type_id = $request->member_type_id;
        $title = $request->title;
        $description = $request->description;
        $creator_id = $request->creator_id;

        $createData = [
            'member_type_id' => $member_type_id,
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
        if ($data) {
            $member_types = MemberType::whereNull('deleted_at')->get();

            return view(
                'notification.detail',
                compact('data', 'member_types'),
            );
        } else {
            return redirect()
                ->route('notification.index')
                ->with([
                    'error' => "Gagal mengedit data - notifikasi pesan dengan id {$id} tidak ditemukan.",
                ]);
        }
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
        if ($data) {
            $member_types = MemberType::whereNull('deleted_at')->get();

            return view(
                'notification.edit',
                compact('data', 'member_types'),
            );
        } else {
            return redirect()
                ->route('notification.index')
                ->with([
                    'error' => "Gagal mengedit data - Notifikasi Pesan dengan id {$id} tidak ditemukan.",
                ]);
        }
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
            'member_type_id.required' => 'Tipe Member tidak boleh kosong',
            'creator_id.required' => 'Kreator Pesan tidak boleh kosong',
        ];

        $validator = Validator::make($request->all(), [
            'description' => 'required|max:255',
            'member_type_id' => 'required',
            'title' => 'required',
        ], $messages);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)
                ->withInput();
        }

        $member_type_id = $request->member_type_id;
        $title = $request->title;
        $description = $request->description;
        $creator_id = $request->creator_id;

        $updateData = [
            'member_type_id' => $member_type_id,
            'title' => $title,
            'description' => $description,
            'creator_id' => $creator_id,
        ];

        $result = $this->NotificationRepository->update($id, $updateData);

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
                ->with('success', 'Data Notifikasi pesan telah berhasil dihapus.');
        } else {
            return back()->withInput()->with('info', 'Gagal menghapus data notifikasi pesan Fitur Panel');
        }
    }
}
