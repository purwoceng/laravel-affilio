<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductTypeController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        return view('content.product_home.types');
    }

    public function create()
    {
        return view('content.product_home.create-type');
    }

    public function store(Request $request)
    {
        // 
    }
}
