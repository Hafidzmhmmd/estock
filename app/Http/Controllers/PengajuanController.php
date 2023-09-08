<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\KelompokBarang;
use App\SubKelompok;
use App\SubSubKelompok;

class PengajuanController extends Controller
{
    public function pembelian()
    {
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all();
        return view('modules.pengajuan.pembelian',$data);
    }
}
