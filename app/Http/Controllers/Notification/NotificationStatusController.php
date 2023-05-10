<?php

namespace App\Http\Controllers\Notification;

use App\Models\MemberType;
use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\Notification\NotificationStatusRepository;

class NotificationStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $NotificationStatusRepository;

    public function __construct(NotificationStatusRepository $NotificationStatusRepository)
    {
        $this->NotificationStatusRepository = $NotificationStatusRepository;
    }
    public function index(Request $request)
    {
        $notification = Notification::with('notifications_status')->where('id')->get();
        if ($request->ajax()) {
            return $this->NotificationStatusRepository->getDataTable($request);
        }

        return view('notificationstatus.index', compact('notification'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $data = Notification::findorfail($id);
        $member_types = MemberType::whereNull('deleted_at')->get();
        return view('notificationstatus.create',compact('data','member_types'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
