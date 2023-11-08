<?php

namespace App\Http\Controllers;

use App\Http\Helpers\AccessHelpers;
use App\KelompokBarang;
use Illuminate\Http\Request; 

class KelompokController extends Controller
{
    public function store(Request $request)
    {
        $message = '';
        $status = false;

        if (AccessHelpers::isAdmin()) {  
            
            $id = $request->id;
            $kel_id = $request->kel_id;
            $bid_id = $request->bid_id;
            $gol_id = $request->gol_id;
            $kelompok = $request->kelompok;

            if ($id) {
                $Kel = KelompokBarang::where('id', $id)->first();
            } else {
                $Kel = new KelompokBarang();
            }
 
            $Kel->kel_id = $kel_id;
            $Kel->bid_id = $bid_id;
            $Kel->gol_id = $gol_id;
            $Kel->kelompok = $kelompok;

            if($Kel->save()) { 
                $message = 'Kelompok Berhasil Disimpan';
                $status = true;
            } else {
                $message = 'Gagal Menyimpan Kelompok';
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
                $data = KelompokBarang::where('id', $request->id)->first();
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
                $data = KelompokBarang::where('id', $request->id)->delete();  
    
                if ($data) {
                    $message = 'Kelompok Berhasil Dihapus';
                    $status = true;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ]; 
                } else {
                    $message = 'Gagal Menghapus Kelompok';
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
