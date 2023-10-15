<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gudang;
use App\Barang;
use App\StockGudang;
use App\RiwayatGudang;
use App\ChangeLog;
use App\Pengajuan;
use App\PengajuanDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\RiwayatHelpers;
use App\Http\Helpers\CounterHelpers;
use App\Http\Helpers\StockHelpers;
use Illuminate\Database\Eloquent\Builder;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = Gudang::select('*');
        // $riwayat = RiwayatGudang::select('*')->with('hasStockId.hasBarang');
        $user = Auth::user();
        $data['pengelolaGudang'] = false;
        if(!in_array($user->role,config('app.akses.gudangall'))){
            $gudang = $gudang->where('bidang_id', $user->bidang);
            // $riwayat =  $riwayat->whereHas('hasStockId.hasBarang', function (Builder $query) {
            //     $query->where('gudang_id', '=', '1');
            // });
        } else {
            $data['pengelolaGudang'] = true;
        }
        $data['gudang'] = $gudang->get();
        // $data['riwayat'] = $riwayat->orderBy('created_at','desc')->get();
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
                    $logs = [];
                    foreach($value as $item){
                        $find = StockGudang::where('gudang_id', $key)->where('barang_id', $item['barang_id'])->where('stock','>',0);
                        $fCount = $find->count();
                        if($fCount == 1){
                            $data = $find->first();
                            $before = $data->stock;
                            $stock = intval($before) - intval($item['jumlah']);
                            if($stock >= 0){
                                $data->stock = $stock;
                                $data->save();

                                $log = RiwayatHelpers::changeLog((object)[
                                    'gudangid' => $key,
                                    'barangid' => $item['barang_id'],
                                    'before' => $before,
                                    'after' => $stock,
                                    'draftcode' => $data->draftcode,
                                    'stock_id' => $data->stock_id,
                                    'keterangan' => 'pengambilan barang',
                                    'jumlah' => $item['jumlah'],
                                    'status' => 1,
                                ]);
                            } else {
                                $log = RiwayatHelpers::changeLog((object)[
                                    'gudangid' => $key,
                                    'barangid' => $item['barang_id'],
                                    'before' => $before,
                                    'after' => $before,
                                    'draftcode' => $data->draftcode,
                                    'stock_id' => $data->stock_id,
                                    'keterangan' => 'pengambilan barang',
                                    'jumlah' => $item['jumlah'],
                                    'status' => 0,
                                ]);
                            }
                        }
                        else if($fCount >= 1)
                        {
                            $datas = $find->orderBy('created_at','asc')->get();
                            $jumlah = $item['jumlah'];
                            $totalJumlah = $find->sum('stock');
                            if($jumlah >= 0 && $jumlah <= $totalJumlah){
                                foreach($datas as $data){
                                    if($jumlah != 0){
                                        $before = $data->stock;
                                        $stock = intval($before) - intval($jumlah);
                                        $take = intval($jumlah);
                                        if($stock >= 0){
                                            $data->stock = $stock;
                                            $jumlah = 0;
                                        }
                                        else if($stock < 0){
                                            $take = $before;
                                            $jumlah = $stock * -1;
                                            $stock = 0;
                                            $data->stock = $stock;
                                        }
                                        $data->save();

                                        $log = RiwayatHelpers::changeLog((object)[
                                            'gudangid' => $key,
                                            'barangid' => $item['barang_id'],
                                            'before' => $before,
                                            'after' => $stock,
                                            'draftcode' => $data->draftcode,
                                            'stock_id' => $data->stock_id,
                                            'keterangan' => 'pengambilan barang',
                                            'jumlah' => $take,
                                            'status' => 1,
                                        ]);
                                    }
                                }
                            } else {
                                $log = RiwayatHelpers::changeLog((object)[
                                    'gudangid' => $key,
                                    'barangid' => $item['barang_id'],
                                    'before' =>$totalJumlah,
                                    'after' => $totalJumlah,
                                    'draftcode' => '',
                                    'stock_id' => '',
                                    'keterangan' => 'pengambilan barang',
                                    'jumlah' => $item['jumlah'],
                                    'status' => 0,
                                ]);
                            }
                        }

                        if($log){;
                            array_push($logs,$log);
                        }
                    }
                    if(count($logs) > 0){
                        $nomor = CounterHelpers::NomorPengambilan();
                        $user = Auth::user();
                        $log = RiwayatHelpers::log((object)[
                            'arah' => config('app.flow.keluar'),
                            'draftcode' => $nomor,
                            'bidangid' => $user->bidang,
                            'gudangid' => $key,
                        ], $logs);
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

    public function riwayat(){
        $user = Auth::user();
        $gudang = Gudang::where('bidang_id', $user->bidang)->first();
        $riwayat = RiwayatGudang::where('gudangid', $gudang->id)->where('bidangid', $user->bidang)->orderBy('id', 'desc')->paginate(10);
        return response()->json($riwayat);
    }

    public function riwayatDetails(Request $request){
        $riwayat = RiwayatGudang::find($request->id);
        if($riwayat->arah == 3){
            $record = ChangeLog::where('riwayat_id', $riwayat->id)->get();
            $arr = [];
            foreach ($record as $rec){
                $barang = Barang::find($rec->barangid);
                $avg_satuan = StockHelpers::hargaBarangGudang($rec->barangid);
                $arr[] = [
                    'nama_barang' => $barang->uraian,
                    'jumlah_barang' => $rec->jumlah,
                    'satuan' => $barang->satuan,
                    'total_harga' => $avg_satuan * $rec->jumlah
                ];
            }
            $data['details'] = $arr;
        } else {
            $data['details'] = PengajuanDetail::where('draftcode', $riwayat->draftcode)->get();
        }

        return response()->json($data);
    }
}
