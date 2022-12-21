<?php

namespace App\Http\Controllers;

use App\Models\markup;
use Illuminate\Http\Request;

class MarkupController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->getDataTable($request);
        }

        return view('content.markup.index');
    }
}
