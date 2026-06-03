<?php

namespace App\Http\Controllers\Homestay;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomestayController extends Controller
{
    /**
     * Tampilkan daftar homestay.
     */
    public function index()
    {
        return view('homestay.index');
    }
}
