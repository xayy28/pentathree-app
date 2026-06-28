<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi untuk admin.
     */
    public function index()
    {
        return view('admin.reservasi.index');
    }
}
