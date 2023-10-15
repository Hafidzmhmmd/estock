<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\ChangeLog;
use App\RiwayatGudang;
use App\Gudang;
use App\Barang;
use PDF;


class FileController extends Controller
{
    public function getfile($folder, $filename){
        $exists = Storage::disk('local')->exists("$folder/$filename");
        if($exists){
            $file = Storage::disk('local')->get("$folder/$filename");
            return (new Response($file))->header('Content-Type', mime_content_type(Storage::disk('local')->path("$folder/$filename")));
        }
    }

    public function pdfPengambilan(Request $request){
        $riwayat = RiwayatGudang::find($request->riwayat);
        $data['detail'] = $riwayat;
        $data['gudang'] = Gudang::find($riwayat->gudangid);
        $list = ChangeLog::where('riwayat_id', $request->riwayat)->get();
        foreach($list as $li){
            $li->barang = Barang::find($li->barangid);
        }
        $data['list'] = $list;
        $pdf = PDF::loadView('_pdf.pengambilan', $data);

        return $pdf->stream($riwayat->draftcode.'.pdf');
    }
}
