<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Gudang;
use App\RiwayatGudang;
use App\SubSubKelompok;
use App\Barang;
use Carbon\Carbon;
use App\StockGudang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use PDF;

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
        $date_start = $request->date_start;
        $dateS = Carbon::createFromFormat('d/m/Y', $date_start);
        $date_end = $request->date_end;
        $dateE = Carbon::createFromFormat('d/m/Y',  $date_end);
        $data['dstart'] = $date_start;
        $data['dend'] = $date_end;
        $subsub = SubSubKelompok::all();
        foreach ($subsub as $ss){
            //get stock until before date
            // $b_pengajuan =

            // get all barang by subsub
            $identifier = $ss["sub_subkel_id"].$ss["subkel_id"].$ss["kel_id"].$ss["bid_id"].$ss["gol_id"];
            $barang = Barang::whereRaw("CONCAT(sub_subkel_id,subkel_id,kel_id,bid_id,gol_id) = ?", [$identifier])->get();
            $ss->barang = $barang;
        }

        $data['subsubkel'] = $subsub;
        // $data['row'] = RiwayatGudang::whereBetween('created_at', [$dateS->format('Y-m-d')." 00:00:00", $dateE->format('Y-m-d')." 23:59:59"])->get();

        $pdf = PDF::loadView('_pdf.opname', $data);
        $pdf->setPaper('A4', 'landscape');
        $output = $pdf->output();


        $filename = "opnametest.pdf";
        $path = "opname/$filename";
        Storage::disk('local')->put($path, $output);

        dd($data);
    }
}
