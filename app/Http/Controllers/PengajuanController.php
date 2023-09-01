<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PengajuanController extends Controller
{
    public function pembelian()
    {
        return view('modules.pengajuan.pembelian');
    }
}
