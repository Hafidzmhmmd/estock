<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Barang;
use App\KelompokBarang;
use App\Pengajuan;
use App\PengajuanDetail;
use App\SubKelompok;
use App\SubSubKelompok;
use App\Gudang;
use App\StockGudang;
use App\Flow;
use App\Http\Helpers\RiwayatHelpers;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Http\Helpers\FlowHelpers;
use Illuminate\Support\Facades\Storage;

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
            $draftcode = null;
            $find = true;
            while($find){
                $draftcode = Str::random(6);
                $exist = Pengajuan::where('draftcode', $draftcode)->count();
                if(!$exist){
                    $find = false;
                }
            }

        }
        $dtPengajuan->id_pemohon = $user->id;
        $dtPengajuan->bidang = $user->bidang;
        $firstFlow = Flow::where('step',1)->first();
        $dtPengajuan->flow = $firstFlow->id;
        $dtPengajuan->status = $firstFlow->status;
        if(isset($request->ajukan) && $request->ajukan == 1){
            $dtPengajuan->status = 'P';
            $dtPengajuan->tgl_pengajuan = new DateTime();
        }
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
                $dtDetail->harga_maksimum = empty($dt['hargaMaks']) ? 0 : $dt['hargaMaks'];
                $dtDetail->harga_satuan = $dt['hargaBarang'];
                $dtDetail->jumlah_barang = $dt['jumlahBarang'];
                $dtDetail->total_harga = $dt['totalHarga'];
                $dtDetail->save();
            }
            if(isset($request->ajukan) && $request->ajukan == 1){
                FlowHelpers::nextFlow($draftcode);
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
            $flow = Flow::find($dtPengajuan->flow);
            if($flow->input_penyedia == 1){
                $dtPengajuan->nama_penyedia = $request->nama_penyedia;
                if($request->file('faktur') != null){
                    $file = $request->file('faktur');
                    $ext = $file->getClientOriginalExtension();
                    $filename = "$request->draftcode.$ext";
                    $path = "faktur/$filename";
                    Storage::disk('local')->put($path, file_get_contents($file));
                    $dtPengajuan->faktur = $path;
                }
                $dtPengajuan->save();
            }


            $flow = FlowHelpers::nextFlow($request->draftcode);
            if($flow->next){
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil menyetujui pengajuan'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $flow->err
                ]);
            }
        }
    }

    public function tolakPengajuan(Request $request)
    {
        if($request->draftcode != '') {
            $flow = FlowHelpers::decline($request->draftcode);
            if($flow->next) {
                return response()->json([
                    'status' => true,
                    'message' => 'Berhasil menolak pengajuan'
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => $flow->err
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

    public function konfirmasiBeli(Request $request)
    {
        $payload = [
            'status' => false,
            'msg' => 'draft permintaan tidak ditemukan'
        ];
        if($request->draftcode != '') {
            $payload = DB::transaction(function() use($request, $payload) {
                $dtPengajuan = Pengajuan::where('draftcode', $request->draftcode)->first();
                if($dtPengajuan->status == 'A'){
                    $dtPengajuan->status = 'F';
                    $dtPengajuan->tgl_konfirmasibeli = new DateTime();

                    $gudangid = Gudang::where('bidang_id', $dtPengajuan->bidang)->pluck('id')->first();
                    $datapengajuan = PengajuanDetail::where('draftcode', $request->draftcode)->get();
                    foreach ($datapengajuan as $data){
                        $before = 0;
                        $row = StockGudang::where('gudang_id', $gudangid)->where('barang_id', $data->id_barang);
                        if($row->count()){
                            $row = $row->first();
                            $before = $row->rencana;
                            if($before > 0){
                                $after = intval($before) - intval($data->jumlah_barang);
                                $row->rencana = $after < 0 ? 0 : $after;
                                $row->stock = $row->stock + intval($data->jumlah_barang);
                                $row->save();
                            } else {
                                $payload['msg'] = 'stock yang anda minta tidak memiliki rencana pembelian';
                            }
                        } else {
                            $payload['msg'] = 'data stock tidak ditemukan';
                        }
                    }

                    if($dtPengajuan->save()) {
                        $payload['status'] = true;
                        $payload['msg'] = 'berhasil menkonfirmasi pembelian';
                    } else {
                        $payload['msg'] = 'gagal memproses permintaan';
                    }
                }
                else
                {
                    $payload['msg'] = 'tidak dapat menkofirmasi perimtaan ini';
                }
                return $payload;
            });
        }
        return response()->json($payload);
    }
}
