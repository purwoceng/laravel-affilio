<?php

namespace App\Http\Controllers\Dana;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\FundTransactionExport;
use App\Repositories\Dana\FundsRepository;

class FundController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $FundsRepository;

    public function __construct(FundsRepository $FundsRepository)
    {
        $this->FundsRepository = $FundsRepository;
    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            return $this->FundsRepository->getDataTable($request);
        }
        return view('dana.fund.index');
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
        $data = $this->FundsRepository->getDataById($id);
        return view('dana.fund.show', compact('data'));
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

        return Excel::download(new FundTransactionExport($status, $dateRange), 'fund.xlsx');
    }

}
