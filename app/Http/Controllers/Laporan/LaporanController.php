<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan laporan.
     */
    public function index()
    {
        return view('laporan.index');
    }
}
