<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\BidangBarang;
use App\KelompokBarang;
use App\SubKelompok;
use App\SubSubKelompok;
use App\Barang;
use Yajra\Datatables\Datatables;

class DataController extends Controller
{
    public function dataBarang()
    {
        $data['bidang_barang'] = BidangBarang::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all();
        return view('modules.data.barang', $data);
    }

    public function barangDataTables(Request $request){
        return datatables(Barang::all())->toJson();
    }
}
