<?php

namespace App\Http\Helpers;

use App\Pengajuan;
use App\PengajuanDetail;
use App\Gudang;
use App\StockGudang;
use App\Http\Helpers\RiwayatHelpers;
use Illuminate\Support\Facades\DB;

class StockHelpers {
    public static function addStockRencana($draftcode){
        $payload = [
            'status' => false,
            'msg' => 'Pengajuan Gagal'
        ];
        $dtPengajuan = Pengajuan::where('draftcode', $draftcode);
        if($dtPengajuan->count()){
            $dtPengajuan =  $dtPengajuan->first();
            $gudang = Gudang::where('bidang_id', $dtPengajuan->bidang);
            if($gudang->count()){
                $gudang = $gudang->first();
                $gudangid = $gudang->id;
                $payload =  DB::transaction(function() use($draftcode, $payload, $gudangid) {
                    $datapengajuan = PengajuanDetail::where('draftcode', $draftcode)->get();
                    $logs = [];
                    foreach ($datapengajuan as $data){
                        $before = 0;
                        $row = StockGudang::where('gudang_id', $gudangid)
                        ->where('barang_id', $data->id_barang)->where('draftcode', $draftcode);
                        if($row->count()){
                            $row = $row->first();
                            $before = $row->rencana;
                            $after = $data->jumlah_barang;
                            $row->rencana = $after;
                            $row->draftcode = $draftcode;
                            $row->save();
                        }
                        else
                        {
                            $row = new StockGudang;
                            $row->gudang_id = $gudangid;
                            $row->barang_id = $data->id_barang;
                            $after = $data->jumlah_barang;
                            $row->rencana = $after;
                            $row->stock = 0;
                            $row->draftcode = $draftcode;
                            $row->save();
                        }

                        $log = RiwayatHelpers::changeLog((object)[
                            'gudangid' => $gudangid,
                            'barangid' => $data->id_barang,
                            'before' => $before,
                            'after' => $after,
                            'draftcode' => $draftcode,
                            'stock_id' => $row->stock_id,
                        ]);
                        if($log){;
                            array_push($logs,$log);
                        }
                    }
                    $payload['status'] = true;
                    $payload['msg'] = 'berhasil memproses pengajuan';
                    $payload['logs'] = $logs;
                    return $payload;
                });
            }
            else {
                $payload['msg'] = 'gudang tidak ditemukan';
            }
        }
        else {
            $payload['msg'] = 'pengajuan tidak ditemukan';
        }
        return $payload;
    }

    public static function setStock($draftcode){
        $payload = [
            'status' => false,
            'msg' => 'Pengajuan Gagal'
        ];
    }
}
