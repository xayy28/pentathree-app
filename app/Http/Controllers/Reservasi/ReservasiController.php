<?php

namespace App\Http\Controllers\Reservasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReservasiController extends Controller
{
    /**
     * Tampilkan daftar reservasi.
     */
    public function index()
    {
        return view('reservasi.index');
    }
}
