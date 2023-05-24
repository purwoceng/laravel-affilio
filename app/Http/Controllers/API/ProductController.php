<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ProductController extends Controller
{
    protected $token;
    protected $endpoint;
    protected $headers;

    public function __construct()
    {
        $this->token = config('app.baleomol_token_auth');
        $this->endpoint = config('app.baleomol_url') . '/affiliator/products?appx=true';
        $this->headers = [
            'Authorization' => "Bearer {$this->token}",
        ];
    }

    public function getProducts(Request $request)
    {
        $queryParams = [];
        $url = $this->endpoint . '/products';

        if ($request->filled('keyword')) $queryParams['keyword'] = $request->get('keyword');

        if ($request->filled('limit')) $queryParams['limit'] = $request->get('limit');

        if ($request->filled('page')) $queryParams['page'] = $request->get('page');

        $response = Http::withHeaders($this->headers)->get($url, $queryParams);

        return response()
            ->json(json_decode($response->body(), 1), $response->status())
            ->header('Content-Type', 'application/json');
    }

    public function getProductById($id)
    {
        $url = $this->endpoint . "/affiliator/products?appx=true/{$id}";
        $response = Http::withHeaders($this->headers)->get($url);

        return response()
            ->json(json_decode($response->body(), 1), $response->status())
            ->header('Content-Type', 'application/json');
    }
}
