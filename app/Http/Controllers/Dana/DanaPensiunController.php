<?php

namespace App\Http\Controllers\Dana;

use App\Exports\PensiunExport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\Dana\DanaPensiunRepository;

class DanaPensiunController extends Controller
{
    protected $danapensiunRepository;

    public function __construct(DanaPensiunRepository $danaPensiunRepository)
    {
        $this->danapensiunRepository = $danaPensiunRepository;
    }
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->danapensiunRepository->getDataTable($request);
        }

        return view('dana.pensiun.index');
    }
    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {
        $data = $this->danapensiunRepository->getDataById($id);
        return view('dana.pensiun.show', compact('data'));
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
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

        return Excel::download(new PensiunExport($status, $dateRange), 'pensiun.xlsx');
    }
}
