<?php

namespace App\Http\Controllers\Pelanggan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi untuk pelanggan.
     */
    public function index()
    {
        return view('pelanggan.reservasi');
    }
}
