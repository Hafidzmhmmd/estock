<?php

namespace App\Http\Controllers;

use App\BidangBarang;
use App\GolonganBarang;
use App\Http\Helpers\AccessHelpers;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;

class BidangBarangController extends Controller
{
    public function store(Request $request)
    {
        $message = '';
        $status = false;

        if (AccessHelpers::isAdmin()) {  
            
            $id = $request->id;
            $bid_id = $request->bid_id;
            $gol_id = $request->gol_id;
            $bidang = $request->bidang; 

            if ($id) {
                $Bid = BidangBarang::where('id', $id)->first();
            } else {
                $Bid = new BidangBarang();
            }
 
            $Bid->bid_id = $bid_id;
            $Bid->gol_id = $gol_id;
            $Bid->bidang = $bidang; 

            if($Bid->save()) { 
                $message = 'Bidang Berhasil Disimpan';
                $status = true;
            } else {
                $message = 'Gagal Menyimpan Bidang';
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
                $data = BidangBarang::where('id', $request->id)->first();
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
                $data = BidangBarang::where('id', $request->id)->delete();  
    
                if ($data) {
                    $message = 'Bidang Berhasil Dihapus';
                    $status = true;
                    $result = [
                        'status' => $status,
                        'message' => $message
                    ]; 
                } else {
                    $message = 'Gagal Menghapus Bidang';
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
