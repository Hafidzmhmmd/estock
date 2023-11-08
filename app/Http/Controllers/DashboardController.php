<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Helpers\AccessHelpers;
use Carbon\Carbon;
use App\Pengajuan;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $now = Carbon::now();
        if(AccessHelpers::isPemohon()){
            $data['totalPengajuan'] = Pengajuan::where('bidang',$user->bidang)->whereIn('status', ['A','P','F','C'])->count();
            $data['pengjuanBulan'] = Pengajuan::where('bidang',$user->bidang)->whereMonth('created_at', $now->month)->count();
            $data['proses'] = Pengajuan::where('bidang',$user->bidang)->whereIn('status', ['A','P'])->count();
            $data['disetujui'] = Pengajuan::where('bidang',$user->bidang)->whereIn('status', ['A','F'])->count();
            $view = 'modules.dashboard.pemohon';
        } else {
            $data['totalPengajuan'] = Pengajuan::whereIn('status', ['A','P','F', 'C'])->count();
            $data['pengjuanBulan'] = Pengajuan::whereMonth('created_at', $now->month)->count();
            $data['proses'] = Pengajuan::whereIn('status', ['A','P'])->count();
            $data['disetujui'] = Pengajuan::where('status', 'F')->count();
            $view = 'modules.dashboard.ppk';
        }

        return view($view, $data);
    }
}
