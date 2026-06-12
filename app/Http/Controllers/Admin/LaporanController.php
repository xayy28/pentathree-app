<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LaporanController extends Controller
{
    /**
     * Tampilkan laporan untuk admin.
     */
    public function index()
    {
        return view('admin.laporan');
    }
}
