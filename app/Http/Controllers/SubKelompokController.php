<?php

namespace App\Http\Controllers;

use App\Http\Helpers\AccessHelpers;
use App\SubKelompok;
use Illuminate\Http\Request;

class SubKelompokController extends Controller
{
    public function store(Request $request)
    {
        $message = '';
        $status = false;

        if (AccessHelpers::isAdmin()) {  
            
            $id = $request->id;
            $subkel_id = $request->subkel_id;
            $kel_id = $request->kel_id;
            $bid_id = $request->bid_id;
            $gol_id = $request->gol_id;
            $subkelompok = $request->subkelompok;

            if ($id) {
                $SK = SubKelompok::where('id', $id)->first();
            } else {
                $SK = new SubKelompok();
            }
 
            $SK->subkel_id = $subkel_id;
            $SK->kel_id = $kel_id;
            $SK->bid_id = $bid_id;
            $SK->gol_id = $gol_id;
            $SK->kelompok = $subkelompok;

            if($SK->save()) { 
                $message = 'Sub Kelompok Berhasil Disimpan';
                $status = true;
            } else {
                $message = 'Gagal Menyimpan Sub Kelompok';
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
                $data = SubKelompok::where('id', $request->id)->first();
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
                $data = SubKelompok::where('id', $request->id)->delete();  
    
                if ($data) {
                    $message = 'Sub Kelompok Berhasil Dihapus';
                    $status = true;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ]; 
                } else {
                    $message = 'Gagal Menghapus Sub Kelompok';
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
