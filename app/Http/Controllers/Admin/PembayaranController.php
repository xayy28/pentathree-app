<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Tampilkan daftar pembayaran untuk admin.
     */
    public function index()
    {
        return view('admin.pembayaran.index');
    }
}
