<?php

namespace Custom\Yajra\Http\Controllers;

use Custom\Yajra\Models\Yajra;
use App\Http\Controllers\Controller;

class YajraController extends Controller
{
    public function index()
    {
        $data = 'hello yajra';
        $yajra = Yajra::first();
        return view('custom-yajra::yajra', compact('data', 'yajra'));
    }
}
