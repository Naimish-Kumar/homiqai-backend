<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Style;

class StyleController extends Controller
{
    public function index()
    {
        $styles = Style::all();
        return response()->json($styles);
    }
}
