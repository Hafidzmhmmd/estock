<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\KelompokBarang;
use App\Pengajuan;
use App\PengajuanDetail;
use App\SubKelompok;
use App\SubSubKelompok;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PengajuanController extends Controller
{
    public function pembelian()
    {
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all(); 
        $data['pengajuan'] = null;
        $data['pengajuan_detail'] = null;  

        return view('modules.pengajuan.pembelian',$data);
    }

    public function draft($draftcode)
    {
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all(); 
        $data['pengajuan'] = Pengajuan::where('draftcode', $draftcode)->first();
        $data['pengajuan_detail'] = PengajuanDetail::where('draftcode', $draftcode)->get();  
        if ($data['pengajuan']){ 
            return view('modules.pengajuan.pembelian',$data);
        } else { 
            return redirect()->route('pengajuan.pembelian');
        }
    }

    public function simpandraft(Request $request)
    {
        $user = Auth::user();

        if($request->draftcode != '') {
            $dtPengajuan = Pengajuan::where('draftcode', $request->draftcode)->first(); 
            $draftcode = $request->draftcode; 
        } else {
            $dtPengajuan = new Pengajuan();
            $draftcode = Str::random(6);
        }  
        $dtPengajuan->id_pemohon = $user->id;
        $dtPengajuan->bidang = $user->bidang;
        $dtPengajuan->status = 'D';
        $dtPengajuan->tgl_pengajuan = new DateTime();
        $dtPengajuan->total_keseluruhan = $request->total_keseluruhan;
        $dtPengajuan->draftcode = strtoupper($draftcode);

        if ($request->detail) { 
            $details = json_decode($request->detail, true);
            
            if (json_last_error() != JSON_ERROR_NONE) {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'bad request json'
                ]);
            }
        }
        if($dtPengajuan->save()) {

            PengajuanDetail::where('draftcode', $request->draftcode)->delete();

            foreach($details as $dt) {

                $dtDetail = new PengajuanDetail();
                $dtDetail->draftcode = $dtPengajuan->draftcode;
                $dtDetail->id_barang = $dt['idBarang'];
                $dtDetail->subkel = $dt['subkel'];
                $dtDetail->nama_barang = $dt['namaBarang'];
                $dtDetail->satuan = $dt['satuan'];
                $dtDetail->harga_maksimum = $dt['hargaMaks'];
                $dtDetail->harga_satuan = $dt['hargaBarang'];
                $dtDetail->jumlah_barang = $dt['jumlahBarang'];
                $dtDetail->total_harga = $dt['totalHarga'];
                $dtDetail->penyedia_barang = $dt['penyediaBarang']; 
                $dtDetail->save();
            }

            return response()->json([
                'draftcode' => $dtPengajuan->draftcode,
                'status' => true,
                'message' => 'Data berhasil disimpan'
            ]); 
        }
        else {
            return response()->json([
                'status' => false,
                'message' => 'Gagal menyimpan data'
            ]);
        } 
    }

    public function ajukan(Request $request)
    { 
        if($request->draftcode != '') {
            $dtPengajuan = Pengajuan::where('draftcode', $request->draftcode)->first();  
            $dtPengajuan->status = 'P';
            $dtPengajuan->tgl_pengajuan = new DateTime();

            if($dtPengajuan->save()) {
                return response()->json([ 
                    'status' => true,
                    'message' => 'Pengajuan berhasil'
                ]); 
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan'
                ]);
            }
        }
    }

    public function setujuiPengajuan(Request $request)
    { 
        if($request->draftcode != '') {
            $dtPengajuan = Pengajuan::where('draftcode', $request->draftcode)->first();  
            $dtPengajuan->status = 'A';
            $dtPengajuan->tgl_disetujui = new DateTime();

            if($dtPengajuan->save()) {
                return response()->json([ 
                    'status' => true,
                    'message' => 'Berhasil menyetujui pengajuan'
                ]); 
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan'
                ]);
            }
        }
    }

    public function tolakPengajuan(Request $request)
    { 
        if($request->draftcode != '') {
            $dtPengajuan = Pengajuan::where('draftcode', $request->draftcode)->first();  
            $dtPengajuan->status = 'C';
            $dtPengajuan->tgl_disetujui = new DateTime();

            if($dtPengajuan->save()) {
                return response()->json([ 
                    'status' => true,
                    'message' => 'Berhasil menolak pengajuan'
                ]); 
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Terjadi kesalahan'
                ]);
            }
        }
    }

    public function hapusdraft($draftcode){ 
        
        if ($draftcode) {
            $delPengajuan = Pengajuan::where('draftcode', $draftcode)
                    ->where('status','D')
                    ->delete();

            if($delPengajuan) { 
                $delPengajuan = PengajuanDetail::where('draftcode', $draftcode)->delete(); 
                $message = 'Draft Pengajuan berhasil dihapus';  
                $result = [
                    'status' => true,
                    'message' => $message
                ];
                return response()->json($result,200);

            } else {
                $message = 'Gagal menghapus draft';  
                $result = [
                    'status' => false,
                    'message' => $message
                ];
                return response()->json($result,200);
            }
           
        } else {
            return response()->json([
                'status' => false,
                'message' => 'bad request'
            ]);
        }
        
    }

    public function daftarpembelian()
    {
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all();
        return view('modules.pengajuan.daftarpembelian',$data);
    }
}
