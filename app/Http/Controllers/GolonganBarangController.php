<?php

namespace App\Http\Controllers;

use App\GolonganBarang;
use App\Http\Helpers\AccessHelpers;
use Illuminate\Http\Request;

class GolonganBarangController extends Controller
{
    public function store(Request $request)
    {
        $message = '';
        $status = false;

        if (AccessHelpers::isAdmin()) {  
            
            $id = $request->id; 
            $gol_id = $request->gol_id;
            $golongan = $request->golongan; 

            if ($id) {
                $Gol = GolonganBarang::where('id', $id)->first();
            } else {
                $Gol = new GolonganBarang();
            }
 
            $Gol->gol_id = $gol_id;
            $Gol->golongan = $golongan; 

            if($Gol->save()) { 
                $message = 'Golongan Berhasil Disimpan';
                $status = true;
            } else {
                $message = 'Gagal Menyimpan Golongan';
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
                $data = GolonganBarang::where('id', $request->id)->first();
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

    public function delete(Request $request)
    {
        if(AccessHelpers::isAdmin()) {   
            if ($request->id) { 
                $data = GolonganBarang::where('id', $request->id)->delete();  
    
                if ($data) {
                    $message = 'Golongan Berhasil Dihapus';
                    $status = true;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ]; 
                } else {
                    $message = 'Gagal Menghapus Golongan';
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
