<?php

namespace App\Http\Helpers;

use App\RiwayatGudang;
use App\StockGudang;
use App\ChangeLog;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RiwayatHelpers
{
    public static function accPembelian($data){
        $user = Auth::user();
        $riwayat = new RiwayatGudang;
        $riwayat->stock_id = $data->stock_id;
        $riwayat->jumlah = $data->jumlah;
        $riwayat->before = $data->before;
        $riwayat->after = $data->after;

        $riwayat->userid = $user->id;
        $riwayat->keterangan = "Rencana Pembelian disetujui";
        $riwayat->draftcode = $data->draftcode;
        $riwayat->flow = config('app.flow.rencana');

        $riwayat->save();
    }

    public static function takeout($data){
        $user = Auth::user();
        $riwayat = new RiwayatGudang;
        $riwayat->stock_id = $data->stock_id;
        $riwayat->jumlah = $data->jumlah;
        $riwayat->before = $data->before;
        $riwayat->after = $data->after;

        $riwayat->userid = $user->id;
        $riwayat->keterangan = $data->keterangan;
        $riwayat->flow = config('app.flow.keluar');

        $riwayat->save();
    }

    public static function changeLog($data){
        $user = Auth::user();
        $log = new ChangeLog;
        $log->gudangid = $data->gudangid;
        $log->barangid = $data->barangid;
        $log->before = $data->before;
        $log->after = $data->after;
        $log->draftcode = $data->draftcode;
        $log->stock_id = $data->stock_id;
        $log->keterangan = $data->keterangan;
        $log->jumlah = $data->jumlah;
        $log->status = $data->status;

        if($log->save()){
            return $log->id;
        } else {
            return false;
        };
    }

    public static function log($data, $changelog){
        $user = Auth::user();
        $log = new RiwayatGudang;
        $log->arah = $data->arah;
        $log->userid =  $user->id;
        $log->draftcode = $data->draftcode;

        if($log->save()){
            DB::table('stock_change_log')->whereIn('id', $changelog)
            ->update(['riwayat_id' => $log->id]);
            return $log->id;
        } else {
            return false;
        };
    }
}
