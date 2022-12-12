<?php

namespace App\Http\Controllers\HomePage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function __construct()
    {
        // 
    }

    public function index()
    {
        return view('content.supplier_home.index');
    }
}
