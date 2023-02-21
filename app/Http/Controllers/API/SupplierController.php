<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class SupplierController extends Controller
{
    
    protected $token;
    protected $endpoint;
    protected $headers;

    public function __construct()
    {
        $this->token = config('app.baleomol_key');
        $this->endpoint = config('app.baleomol_url');
        $this->headers = [
            'Authorization' => "Bearer {$this->token}",
        ];
    }

    public function getSuppliers(Request $request)
    {
        $queryParams = [];
        $url = $this->endpoint . '/suppliers';

        if ($request->filled('name')) $queryParams['name'] = $request->get('name');

        if ($request->filled('limit')) $queryParams['limit'] = $request->get('limit');

        if ($request->filled('page')) $queryParams['page'] = $request->get('page');

        $response = Http::withHeaders($this->headers)->get($url, $queryParams);

        return response()
            ->json(json_decode($response->body(), 1), $response->status())
            ->header('Content-Type', 'application/json');
    }

    public function getSupplierById($id)
    {
        $url = $this->endpoint . "/suppliers/{$id}";
        $response = Http::withHeaders($this->headers)->get($url);

        return response()
            ->json(json_decode($response->body(), 1), $response->status())
            ->header('Content-Type', 'application/json');
    }
}
