<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gudang;
use App\StockGudang;
use App\RiwayatGudang;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\RiwayatHelpers;
use Illuminate\Database\Eloquent\Builder;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = Gudang::select('*');
        $riwayat = RiwayatGudang::select('*')->with('hasStockId.hasBarang');
        $user = Auth::user();
        $data['pengelolaGudang'] = false;
        if(!in_array($user->role,config('app.akses.gudangall'))){
            $gudang = $gudang->where('bidang_id', $user->bidang);
            $riwayat =  $riwayat->whereHas('hasStockId.hasBarang', function (Builder $query) {
                $query->where('gudang_id', '=', '1');
            });
        } else {
            $data['pengelolaGudang'] = true;
        }
        $data['gudang'] = $gudang->get();
        $data['riwayat'] = $riwayat->orderBy('created_at','desc')->get();
        return view('modules.gudang.index',$data);
    }

    public function takeout(Request $request){
        $resp = [
            'status' => false,
            'mssg' => null
        ];
        try
        {
            DB::transaction(function() use($request) {
                foreach($request->takeout as $key => $value){
                    //gudangid
                    foreach($value as $item){
                        $find = StockGudang::where('gudang_id', $key)->where('barang_id', $item['barang_id']);
                        if($find->count()){
                            $data = $find->first();
                            $before = $data->stock;
                            $stock = intval($before) - intval($item['jumlah']);
                            if($stock >= 0){
                                $data->stock = $stock;
                                $data->save();
                                RiwayatHelpers::takeout((object)[
                                    'stock_id' => $data->stock_id,
                                    'jumlah' => $item['jumlah'],
                                    'before' => $before,
                                    'after' => $stock,
                                    'keterangan' => $request->keterangan ?? 'pengambilan barang keluar'
                                ]);
                            }
                        }
                    }
                }
            });
            $resp['status'] = true;
        }
        catch (\Illuminate\Database\QueryException $exception)
        {
            $resp['mssg'] = $exception;
        }
        return response()->json($resp);
    }
}
