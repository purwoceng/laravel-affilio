<?php

namespace App\Http\Controllers\City;

use App\Http\Controllers\Controller;
use App\Repositories\City\CityRepository;
use Illuminate\Http\Request;

class CityController extends Controller
{
    protected $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }

    public function index(Request $request)
    {
        $limit = $request->input('limit') ?? 20;
        $start = $request->input('start') ?? 0;
        $name = $request->input('name') ?? '';

        $data = $this->cityRepository->getCities($limit  , $start , $name );

        return response(json_encode($data), 200)->header('Content-Type', 'application/json');

    }
    public function create()
    {
    }

    public function store(Request $request)
    {
    }

    public function show($id)
    {

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
