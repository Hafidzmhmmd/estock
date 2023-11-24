<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Gudang;
use App\RiwayatGudang;
use App\Barang;
use App\KelompokBarang;
use App\Pengajuan;
use App\PengajuanDetail;
use App\SubKelompok;
use App\SubSubKelompok;
use App\LaporanCreate;
use App\StockGudang;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PDF;
use Yajra\Datatables\Datatables;
use App\Http\Helpers\StockHelpers;

class LaporanController extends Controller
{
    public function transaksi(){
        return view('modules.laporan.transaksi.index');
    }

    public function opname(){
        $gudang = Gudang::where('aktif', 1)->get()->pluck('id', 'nama_gudang');
        return view('modules.laporan.opname.index', compact('gudang'));
    }

    public function createOpname(Request $request){
        ini_set('max_execution_time', 6000);
        ini_set('suhosin.memory_limit', '1024M');
        ini_set('memory_limit', '2048M');
        $rsp = ['status' => false];
        $date_start = $request->date_start;
        $dateS = Carbon::createFromFormat('d/m/Y', $date_start);
        $date_end = $request->date_end;
        $dateE = Carbon::createFromFormat('d/m/Y',  $date_end);
        $data['dstart'] = $date_start;
        $data['dend'] = $date_end;
        $subsub = SubSubKelompok::all();
         //get stock until before date
         $string_before = $dateS->format('Y-m-d')." 23:59:59";
         $string_after = $dateE->format('Y-m-d')." 23:59:59";
         $data['b_data'] =DB::select( DB::raw("
             SELECT mt.id_barang, mt.nama_barang, SUM(mt.jumlah_barang) as jumlah, SUM(mt.total_ambil) as ambil, SUM(mt.sisa) as sisa, AVG(mt.harga_satuan) AS harga_rata2,
             SUM(mt.jumlah_barang) * AVG(mt.harga_satuan) as jumlah_harga, SUM(mt.total_ambil) * AVG(mt.harga_satuan) as ambil_harga, SUM(mt.sisa) * AVG(mt.harga_satuan) as sisa_harga
             FROM (SELECT pd.draftcode, pd.id_barang, pd.nama_barang, pd.jumlah_barang
             ,CASE WHEN ot.total_ambil IS NULL THEN 0 ELSE ot.total_ambil END as total_ambil,
             CASE
                 WHEN ot.total_ambil > pd.jumlah_barang THEN 0
                 WHEN ot.total_ambil IS NULL THEN pd.jumlah_barang
                 ELSE pd.jumlah_barang - ot.total_ambil
             END as sisa, harga_satuan
             FROM pengajuan_detail pd
             LEFT JOIN pengajuan p on p.draftcode = pd.draftcode
             LEFT JOIN (
                 SELECT draftcode, barangid, SUM(jumlah) total_ambil FROM stock_change_log
                 WHERE keterangan = 'pengambilan barang' and `status` = 1 AND created_at <= ?
                 GROUP BY draftcode, barangid
                 ORDER BY barangid
             ) ot ON ot.draftcode = pd.draftcode and ot.barangid = pd.id_barang
             WHERE p.`status` = 'F' AND pd.created_at <= ?
             ORDER BY  pd.id_barang, pd.draftcode) mt
             GROUP BY mt.id_barang, mt.nama_barang
         "), [$string_before,$string_before]);

         $data['a_data'] =DB::select( DB::raw("
             SELECT mt.id_barang, mt.nama_barang, SUM(mt.jumlah_barang) as jumlah, SUM(mt.total_ambil) as ambil, SUM(mt.sisa) as sisa, AVG(mt.harga_satuan) AS harga_rata2,
             SUM(mt.jumlah_barang) * AVG(mt.harga_satuan) as jumlah_harga, SUM(mt.total_ambil) * AVG(mt.harga_satuan) as ambil_harga, SUM(mt.sisa) * AVG(mt.harga_satuan) as sisa_harga
             FROM (SELECT pd.draftcode, pd.id_barang, pd.nama_barang, pd.jumlah_barang
             ,CASE WHEN ot.total_ambil IS NULL THEN 0 ELSE ot.total_ambil END as total_ambil,
             CASE
                 WHEN ot.total_ambil > pd.jumlah_barang THEN 0
                 WHEN ot.total_ambil IS NULL THEN pd.jumlah_barang
                 ELSE pd.jumlah_barang - ot.total_ambil
             END as sisa, harga_satuan
             FROM pengajuan_detail pd
             LEFT JOIN pengajuan p on p.draftcode = pd.draftcode
             LEFT JOIN (
                 SELECT draftcode, barangid, SUM(jumlah) total_ambil FROM stock_change_log
                 WHERE keterangan = 'pengambilan barang' and `status` = 1 AND created_at <= ?
                 GROUP BY draftcode, barangid
                 ORDER BY barangid
             ) ot ON ot.draftcode = pd.draftcode and ot.barangid = pd.id_barang
             WHERE p.`status` = 'F' AND pd.created_at <= ?
             ORDER BY  pd.id_barang, pd.draftcode) mt
             GROUP BY mt.id_barang, mt.nama_barang
         "), [$dateE,$dateE]);

        foreach ($subsub as $ss){
            // get all barang by subsub
            $identifier = $ss["sub_subkel_id"].$ss["subkel_id"].$ss["kel_id"].$ss["bid_id"].$ss["gol_id"];
            $barang = Barang::whereRaw("CONCAT(sub_subkel_id,subkel_id,kel_id,bid_id,gol_id) = ?", [$identifier])->get();
            $ss->barang = $barang;
        }

        $data['subsubkel'] = $subsub;
        // $data['row'] = RiwayatGudang::whereBetween('created_at', [$dateS->format('Y-m-d')." 00:00:00", $dateE->format('Y-m-d')." 23:59:59"])->get();
        // dd($data['a_data'], $data['b_data']);
        $html = view('_pdf.opname', $data)->render();
        // $pdf = PDF::loadView('_pdf.opname', $data);
        $pdf = PDF::loadHtml($html);
        $pdf->setPaper('A4', 'landscape');
        $output = $pdf->output();

        $bytes = bin2hex(random_bytes(20));
        $filename = "$bytes.pdf";
        $path = "opname/$filename";
        Storage::disk('local')->put($path, $output);

        $user = Auth::user();
        $createpdf = new LaporanCreate;
        $createpdf->type = 'opname';
        $createpdf->path = $path ;
        $createpdf->author = $user->id;
        if($createpdf->save()){
            $rsp['status'] = true;
        }
        return response()->json($rsp);
    }

    function listOpname(){
        $data = LaporanCreate::where('type','opname')->orderBy('created_at','DESC');
        return Datatables::of($data)->toJson();
    }

    function listBukuPersediaan(){
        $data = LaporanCreate::where('type','persediaan');
        return Datatables::of($data)->toJson();
    }

    public function bukuPersediaan(){
        $subsubkelompok = SubSubKelompok::all();
        $kelompok_barang = KelompokBarang::all();
        $subkelompok = SubKelompok::all();
        $gudang = Gudang::where('aktif', 1)->get()->pluck('id', 'nama_gudang');
        return view('modules.laporan.bukupersediaan.index', compact('gudang', 'subsubkelompok', 'kelompok_barang', 'subkelompok'));
    }

    public function createBukuPersediaan(Request $request){
        $rsp = ['status' => false];
        $date_start = $request->date_start;
        $dateS = Carbon::createFromFormat('d/m/Y', $date_start);
        $date_end = $request->date_end;
        $dateE = Carbon::createFromFormat('d/m/Y',  $date_end);
        $data['dstart'] = $date_start;
        $data['dend'] = $date_end;
        $id_barang = $request->barangid;
        $data['barang'] = Barang::find($id_barang);

        $string_before = $dateS->format('Y-m-d')." 23:59:59";
        $string_after = $dateE->format('Y-m-d')." 23:59:59";
        $data['saldo_awal'] = StockHelpers::getStockOnDate($dateS, $id_barang);
        $data['record_masuk'] = DB::select(DB::raw("
            SELECT pd.id_barang,
                pd.nama_barang,
                pd.harga_satuan,
                pd.jumlah_barang,
                pd.draftcode,
                p.tgl_disetujui
            FROM pengajuan_detail pd
            LEFT JOIN pengajuan p on p.draftcode = pd.draftcode
            WHERE  p.`status` = 'F' AND p.tgl_disetujui >= ? AND pd.id_barang = ? AND p.tgl_disetujui <= ?
            "), [$string_before, $id_barang, $string_after ]);
        $data['record_keluar'] = DB::select(DB::raw("
            SELECT
                sc.draftcode,
                sc.barangid,
                sc.jumlah as ambil,
                sc.created_at,
                p.harga_satuan,
                p.harga_satuan * sc.jumlah as harga_ambil
            FROM
                stock_change_log sc
            LEFT JOIN pengajuan_detail p ON p.draftcode = sc.draftcode AND p.id_barang = sc.barangid
            WHERE
                keterangan = 'pengambilan barang'
                AND sc.status = 1
                AND sc.created_at >= ? AND sc.barangid = ? AND sc.created_at <= ?
            ORDER BY sc.id asc
        "),[$string_before, $id_barang, $string_after ]);

        $pdf = PDF::loadView('_pdf.bukupersediaan', $data);
        $pdf->setPaper('A4', 'landscape');
        $output = $pdf->output();

        $bytes = bin2hex(random_bytes(20));
        $filename = "$bytes.pdf";
        $path = "bukupersediaan/$filename";
        Storage::disk('local')->put($path, $output);

        $user = Auth::user();
        $createpdf = new LaporanCreate;
        $createpdf->type = 'persediaan';
        $createpdf->path = $path ;
        $createpdf->author = $user->id;
        $createpdf->nama_barang = $data['barang']->uraian;
        $createpdf->periode = "$date_start s/d $date_end";
        if($createpdf->save()){
            $rsp['status'] = true;
        }
        return response()->json($rsp);
    }
}
