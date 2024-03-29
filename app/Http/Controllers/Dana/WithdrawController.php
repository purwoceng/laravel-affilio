<?php

namespace App\Http\Controllers\Dana;

use App\Models\Withdraw;
use Illuminate\Http\Request;
use App\Exports\WithdrawExport;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Dana\WithdrawRepository;

class WithdrawController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $WithdrawRepository;

    public function __construct(WithdrawRepository $WithdrawRepository)
    {
        $this->WithdrawRepository = $WithdrawRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->WithdrawRepository->getDataTable($request);
        }
        return view('dana.withdraw.index');
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
        $data = $this->WithdrawRepository->getDataById($id);
        return view('dana.withdraw.show', compact('data'));
    }

    public function verification(Request $request)
    {
        if (!empty($request->id)) {

            $data = [
                'publish' => 1,
            ];
            Withdraw::where('id', $request->id)->update($data);
            return response()->json([
                'status' => 'true',
                'title' => 'Berhasil Suksesi!',
                'message' => 'Berhasil melakukan suksesi penarikan dana',
                'icon' => 'success',
            ]);
        } else {
            return response()->json([
                'status' => 'false',
                'title' => 'Gagal Suksesi !!',
                'message' => 'Gagal melakukan suksesi penarikan dana',
                'icon' => 'warning',
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

        return Excel::download(new WithdrawExport($status, $dateRange), 'withdraw.xlsx');
    }
}
