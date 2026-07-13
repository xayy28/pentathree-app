<?php

namespace App\Http\Controllers;

class InformasiController extends Controller
{
    public function faq()
    {
        return view('pelanggan.informasi.faq');
    }

    public function caraPemesanan()
    {
        return view('pelanggan.informasi.cara-pemesanan');
    }

    public function kebijakanPrivasi()
    {
        return view('pelanggan.informasi.kebijakan-privasi');
    }

    public function syaratKetentuan()
    {
        return view('pelanggan.informasi.syarat-ketentuan');
    }
}
