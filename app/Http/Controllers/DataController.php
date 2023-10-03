<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\BidangBarang;
use App\KelompokBarang;
use App\SubKelompok;
use App\SubSubKelompok;
use App\Barang;
use App\Pengajuan;
use App\PengajuanDetail;
use App\StockGudang;
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

    public function pengajuanDataTables(Request $request){
        $user = Auth::user();
        $data = Pengajuan::select('*')->orderBy('id','desc');
        if($request->level == 1){
            $data = $data->where('bidang', $user->bidang)->whereIn('status', ['A','P','F','C']);
        }
        else if ($request->level == 2){
            $data = $data->whereIn('status', ['A','P','F']);
        } else {
            $data = $data->where('id_pemohon', $user->id);
        }
        return Datatables::of($data)->toJson();
    }

    public function pengajuandetailDataTables(Request $request){
        $data = PengajuanDetail::where('draftcode', $request->draftcode)->get();
        return Datatables::of($data)->toJson();
    }

    public function stockgudangDataTables(Request $request){
        $user = Auth::user();
        $gudang_id = $request->gudang_id;
        if(empty($gudang_id)){
            if(in_array($user->role,config('app.akses.gudangall'))){
                $data = DB::table('stock_gudang')->leftJoin('m_barang','stock_gudang.barang_id','=','m_barang.id');
            }
        } else {
            $data = DB::table('stock_gudang')->leftJoin('m_barang','stock_gudang.barang_id','=','m_barang.id')
            ->where('gudang_id', $gudang_id);
        }
        if(isset($data)){
            return Datatables::of($data)->toJson();
        } else {
            return null;
        }
    }
}
