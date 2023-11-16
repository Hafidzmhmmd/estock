<?php

namespace App\Http\Helpers;

use App\Pengajuan;
use App\PengajuanDetail;
use App\Gudang;
use App\Barang;
use App\StockGudang;
use App\Http\Helpers\RiwayatHelpers;
use Illuminate\Support\Facades\DB;

class StockHelpers {
    public static function addStockRencana($dtPengajuan){
        $payload = [
            'status' => false,
            'msg' => 'Pengajuan Gagal'
        ];
        $draftcode = $dtPengajuan->draftcode;
        if($dtPengajuan->count()){
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
                            'keterangan' => 'persetujuan rencana',
                            'jumlah' => $data->jumlah_barang,
                            'status' => 1,
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

    public static function setStock($dtPengajuan){
        $payload = [
            'status' => false,
            'msg' => 'Pengajuan Gagal'
        ];
        $draftcode = $dtPengajuan->draftcode;
        if($dtPengajuan->count()){
            $gudang = Gudang::where('bidang_id', $dtPengajuan->bidang);
            if($gudang->count()){
                $gudang = $gudang->first();
                $gudangid = $gudang->id;
                $payload =  DB::transaction(function() use($draftcode, $payload, $gudangid) {
                    $datapengajuan = PengajuanDetail::where('draftcode', $draftcode)->get();
                    $logs = [];
                    foreach ($datapengajuan as $data){
                        $before = 0;
                        $log = null;
                        $row = StockGudang::where('gudang_id', $gudangid)
                            ->where('barang_id', $data->id_barang)->where('draftcode', $draftcode);
                        if($row->count()){
                            $row = $row->first();
                            $before = $row->rencana;
                            if($before >= intval($data->jumlah_barang)){
                                $after = intval($before) - intval($data->jumlah_barang);
                                $row->rencana = $after < 0 ? 0 : $after;
                                $row->stock = $row->stock + intval($data->jumlah_barang);
                                $row->save();

                                $log = RiwayatHelpers::changeLog((object)[
                                    'gudangid' => $gudangid,
                                    'barangid' => $data->id_barang,
                                    'before' => $before,
                                    'after' => $after,
                                    'draftcode' => $draftcode,
                                    'stock_id' => $row->stock_id,
                                    'keterangan' => 'konfirmasi pembelian',
                                    'jumlah' => $data->jumlah_barang,
                                    'status' => 1,
                                ]);
                            } else {
                                $log = RiwayatHelpers::changeLog((object)[
                                    'gudangid' => $gudangid,
                                    'barangid' => $data->id_barang,
                                    'before' => $before,
                                    'after' => $before,
                                    'draftcode' => $draftcode,
                                    'stock_id' => $row->stock_id,
                                    'keterangan' => 'konfirmasi pembelian',
                                    'jumlah' => $data->jumlah_barang,
                                    'status' => 0,
                                ]);
                            }
                        } else {
                            $log = RiwayatHelpers::changeLog((object)[
                                'gudangid' => $gudangid,
                                'barangid' => $data->id_barang,
                                'before' => 0,
                                'after' => 0,
                                'draftcode' => $draftcode,
                                'keterangan' => 'konfirmasi pembelian',
                                'jumlah' => 0,
                                'status' => 0,
                            ]);
                        }

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

    public static function hargaBarangGudang($barangid){
        $stock = StockGudang::where('barang_id', $barangid)
            ->orWhere(function($query){
                $query->where('rencana', '>', 0);
                $query->orWhere('stock', '>', 0);
            });
        if($stock->count()){
            $draftcodes = $stock->pluck('draftcode');
            $avg = PengajuanDetail::where('id_barang', $barangid)->whereIn('draftcode', $draftcodes)->avg('harga_satuan');
            return round($avg);
        } else {
            return 0;
        }
    }

    public static function getStockOnDate($dateS,$id_barang){
        $date = $dateS->format('Y-m-d')." 23:59:59";
        $param = [$date,$date];
        if($id_barang){
            $strBarang = ' AND pd.id_barang = ? ';
            $param = [$date,$date, $id_barang];
        }
        $data =  DB::select( DB::raw("
        SELECT
            pd.draftcode,
            pd.id_barang,
            pd.nama_barang,
            pd.jumlah_barang,
            harga_satuan,
            ot.jumlah as ambil,
            pd.jumlah_barang - COALESCE(ot.jumlah, 0) as stock,
            (pd.jumlah_barang - ot.jumlah) * harga_satuan as saldo
        FROM
            pengajuan_detail pd
            LEFT JOIN pengajuan p ON p.draftcode = pd.draftcode
            LEFT JOIN ( SELECT draftcode, barangid, SUM(jumlah) as jumlah
            FROM stock_change_log
            WHERE keterangan = 'pengambilan barang' AND `status` = 1
            AND created_at <= ?
            GROUP BY  draftcode, barangid
            ) ot ON ot.draftcode = pd.draftcode
            AND ot.barangid = pd.id_barang
        WHERE
            p.`status` = 'F'
            AND pd.jumlah_barang - COALESCE(ot.jumlah, 0) > 0
            AND p.tgl_disetujui <= ?
            $strBarang
        ORDER BY
            pd.id_barang,
            pd.draftcode,
            pd.created_at
        "), $param);
        return $data;
    }
}
