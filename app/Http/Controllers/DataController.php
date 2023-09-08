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
        $ssk = SubSubKelompok::all()->toArray();
        $subsub = [];
        foreach ($ssk as $s){
            $identifier = $s["sub_subkel_id"].$s["subkel_id"].$s["kel_id"].$s["bid_id"].$s["gol_id"];
            $subsub[$identifier] = $s["sub_subkelompok"];
        }
        return Datatables::of($data)
        ->editColumn('subsubkelompok', function($data) use($subsub)
        {
            $identifier = $data->sub_subkel_id.$data->subkel_id.$data->kel_id.$data->bid_id.$data->gol_id;
           return $subsub[$identifier];
        })
        ->filter(function ($instance) use ($request) {
            if (!empty($request->kel)) {
                $instance->whereRaw("CONCAT(kel_id,bid_id,gol_id) = ?",[$request->kel]);
            }
            if (!empty($request->subkel)) {
                $instance->whereRaw("CONCAT(subkel_id,kel_id,bid_id,gol_id) = ?",[$request->subkel]);
            }
            if (!empty($request->subsub)) {
                $instance->whereRaw("CONCAT(sub_subkel_id,subkel_id,kel_id,bid_id,gol_id) = ?",[$request->subsub]);
            }
        })
        ->toJson();
    }
}
