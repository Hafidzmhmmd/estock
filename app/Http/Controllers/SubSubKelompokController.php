<?php

namespace App\Http\Controllers;

use App\Http\Helpers\AccessHelpers;
use App\SubSubKelompok;
use Illuminate\Http\Request;

class SubSubKelompokController extends Controller
{
    public function store(Request $request)
    {
        $message = '';
        $status = false;

        if (AccessHelpers::isAdmin()) {  
            
            $id = $request->id;
            $sub_subkel_id = $request->sub_subkel_id;
            $subkel_id = $request->subkel_id;
            $kel_id = $request->kel_id;
            $bid_id = $request->bid_id;
            $gol_id = $request->gol_id;
            $sub_subkelompok = $request->sub_subkelompok; 

            if ($id) {
                $SSK = SubSubKelompok::where('id', $id)->first();
            } else {
                $SSK = new SubSubKelompok();
            }
 
            $SSK->sub_subkel_id = $sub_subkel_id;
            $SSK->subkel_id = $subkel_id;
            $SSK->kel_id = $kel_id;
            $SSK->bid_id = $bid_id;
            $SSK->gol_id = $gol_id;
            $SSK->sub_subkelompok = $sub_subkelompok;

            if($SSK->save()) { 
                $message = 'Sub Sub Kelompok Berhasil Disimpan';
                $status = true;
            } else {
                $message = 'Gagal Menyimpan Sub Sub Kelompok';
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
                $data = SubSubKelompok::where('id', $request->id)->first();
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
                $data = SubSubKelompok::where('id', $request->id)->delete();  
    
                if ($data) {
                    $message = 'Sub Sub Kelompok Berhasil Dihapus';
                    $status = true;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ]; 
                } else {
                    $message = 'Gagal Menghapus Sub Sub Kelompok';
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
