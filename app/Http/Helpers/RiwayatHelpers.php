<?php

namespace App\Http\Helpers;

use App\RiwayatGudang;
use App\StockGudang;
use Illuminate\Support\Facades\Auth;

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

}
