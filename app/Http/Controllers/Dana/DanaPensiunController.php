<?php

namespace App\Http\Controllers\Dana;

use App\Http\Controllers\Controller;
use App\Repositories\Dana\DanaPensiunRepository;
use Illuminate\Http\Request;

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
}
