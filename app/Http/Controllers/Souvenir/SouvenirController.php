<?php

namespace App\Http\Controllers\Souvenir;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SouvenirController extends Controller
{
    /**
     * Tampilkan daftar souvenir.
     */
    public function index()
    {
        return view('souvenir.index');
    }
}
