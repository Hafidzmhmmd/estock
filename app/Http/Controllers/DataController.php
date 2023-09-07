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
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all();
        return view('modules.data.barang', $data);
    }

    public function barangDataTables(Request $request){
        $data = Barang::select('*');
        $ssk = SubSubKelompok::pluck('sub_subkelompok','sub_subkel_id')->toArray();
        return Datatables::of($data)
        ->editColumn('subsubkelompok', function($data) use($ssk)
        {
           return $ssk[$data->sub_subkel_id];
        })
        ->filter(function ($instance) use ($request) {
            if (!empty($request->subkel)) {
                $instance->where('subkel_id', $request->subkel);
            }
            if (!empty($request->subsub)) {
                $instance->where('sub_subkel_id', $request->subsub);
            }
            if (!empty($request->kel)) {
                $instance->where('kel_id', $request->kel);
            }
        })
        ->toJson();
    }
}
