<?php

namespace App\Http\Controllers\Dana;

use App\Exports\BonusAcaraExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Dana\EventfundRepository;

class EventfundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $EventfundRepository;

    public function __construct(EventfundRepository $EventfundRepository)
    {
        $this->EventfundRepository = $EventfundRepository;
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->EventfundRepository->getDataTable($request);
        }
        return view('dana.acara.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        $data = $this->EventfundRepository->getDataById($id);
        return view('dana.acara.detail', compact('data'));
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

    public function exportexcel(Request $request)
    {
        $dateRange = [];
        $status = '';

        if (isset($request->daterange1)) {
            $dateRange = explode('-', $request->daterange1);
            $dateRange = array_map(function ($item) {
                $date = trim($item);
                $date = strtotime($date);
                $date = date('Y-m-d H:i:s', $date);

                return $date;
            }, $dateRange);
        }

        if (isset($request->status1)) {
            $status = $request->status1;
        }

        return Excel::download(new BonusAcaraExport($status, $dateRange), 'bonusacara.xlsx');
    }
}
