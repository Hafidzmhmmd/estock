<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Gudang;
use Illuminate\Support\Facades\Auth;

class GudangController extends Controller
{
    public function index()
    {
        $gudang = Gudang::select('*');
        $user = Auth::user();
        $data['pengelolaGudang'] = false;
        if(!in_array($user->role,config('app.akses.gudangall'))){
            $gudang = $gudang->where('bidang_id', $user->bidang);
        } else {
            $data['pengelolaGudang'] = true;
        }
        $data['gudang'] = $gudang->get();
        return view('modules.gudang.index',$data);
    }
}
