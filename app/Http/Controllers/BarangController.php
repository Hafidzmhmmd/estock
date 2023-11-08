<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Barang;
use App\BidangBarang;
use App\GolonganBarang;
use App\Http\Helpers\AccessHelpers;
use App\KelompokBarang;
use App\SubKelompok;
use App\SubSubKelompok;

class BarangController extends Controller
{ 
    public function store(Request $request)
    {
        $message = '';
        $status = false;

        if (AccessHelpers::isAdmin()) {  
            
            $gol_id = $request->golongan;
            $bid_id = $request->bidang;
            $kel_id = $request->kel;
            $subkel_id = $request->subkel;
            $sub_subkel_id = $request->sub_subkel;
            $kode = $request->kode;
            $uraian = $request->uraian;
            $satuan = $request->satuan;
            $harga_maksimum = $request->harga_maksimum;
            $id_barang = $request->idbarang;

            if ($id_barang) {
                $Brng = Barang::where('id', $request->idbarang)->first();
            } else {
                $Brng = new Barang();
            }
 
            $Brng->gol_id = $gol_id;
            $Brng->bid_id = $bid_id;
            $Brng->kel_id = $kel_id;
            $Brng->subkel_id = $subkel_id;
            $Brng->sub_subkel_id = $sub_subkel_id;
            $Brng->kode = $kode;
            $Brng->uraian = $uraian;
            $Brng->satuan = $satuan;
            $Brng->harga_maksimum = $harga_maksimum;

            if($Brng->save()) { 
                $message = 'Barang Berhasil Disimpan';
                $status = true;
            } else {
                $message = 'Gagal Menyimpan Barang';
                $status = false;
            }

            $result = [
                'status' => $status,
                'message' => $message
            ];
            return response()->json($result, 200);

        } else {
            return response()->json([
                'status' => $status,
                'message' => 'Anda tidak memiliki akses'
            ]);
        }
    }

    public function detail(Request $request)
    {
        if (AccessHelpers::isAdmin()) { 
            if ($request->id) {
                $data = Barang::where('id', $request->id)->first();
                if ($data) {
                    return response()->json([
                        'status' => 'success',
                        'msg' => 'berhasil mendapatkan data',
                        'data' => $data
                    ]);
                } else {
                    return response()->json([
                        'status' => 'error',
                        'msg' => 'data tidak ditemukan'
                    ]);
                }
            } else {
                return response()->json([
                    'status' => 'error',
                    'msg' => 'bad request'
                ]);
            } 
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        }
    } 

    public function delete(Request $request){
        if(AccessHelpers::isAdmin()) {   
            if ($request->id) { 
                $data = Barang::where('id', $request->id)->delete();  
    
                if ($data) {
                    $message = 'Barang Berhasil Dihapus';
                    $status = true;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ]; 
                } else {
                    $message = 'Gagal Menghapus Barang';
                    $status = false;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ];  
                }
                return response()->json($result,200);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'bad request'
                ]);
            }    
        } else {
            return response()->json([
                'status' => 'error',
                'msg' => 'anda tidak memiliki akses untuk melakukan operasi ini'
            ]);
        } 
    }

}
