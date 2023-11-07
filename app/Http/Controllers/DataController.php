<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\BidangBarang;
use App\KelompokBarang;
use App\SubKelompok;
use App\SubSubKelompok;
use App\Barang;
use App\Pengajuan;
use App\PengajuanDetail;
use App\StockGudang;
use App\Flow;
use App\User;
use App\UserBidang;
use App\Gudang;
use Yajra\Datatables\Datatables;

class DataController extends Controller
{
    public function dataBarang()
    {
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all();
        return view('modules.data.barang', $data);
    }

    public function barangDataTables(Request $request){
        $data = Barang::select('*');
        $ssk = SubSubKelompok::all()->toArray();
        $subsub = [];
        foreach ($ssk as $s){
            $identifier = $s["sub_subkel_id"].$s["subkel_id"].$s["kel_id"].$s["bid_id"].$s["gol_id"];
            $subsub[$identifier] = $s["sub_subkelompok"];
        }
        return Datatables::of($data)
        ->editColumn('subsubkelompok', function($data) use($subsub)
        {
            $identifier = $data->sub_subkel_id.$data->subkel_id.$data->kel_id.$data->bid_id.$data->gol_id;
           return $subsub[$identifier];
        })
        ->filter(function ($instance) use ($request) {
            if (!empty($request->kel)) {
                $instance->whereRaw("CONCAT(kel_id,bid_id,gol_id) = ?",[$request->kel]);
            }
            if (!empty($request->subkel)) {
                $instance->whereRaw("CONCAT(subkel_id,kel_id,bid_id,gol_id) = ?",[$request->subkel]);
            }
            if (!empty($request->subsub)) {
                $instance->whereRaw("CONCAT(sub_subkel_id,subkel_id,kel_id,bid_id,gol_id) = ?",[$request->subsub]);
            }
        })
        ->toJson();
    }

    public function pengajuanDataTables(Request $request){
        $user = Auth::user();
        $data = Pengajuan::select('*')->orderBy('id','desc');
        if($request->level == 1){
            $data = $data->where('bidang', $user->bidang)->whereIn('status', ['A','P','F','C']);
        }
        else if ($request->level == 2){
            $data = $data->whereIn('status', ['A','P','F']);
        } else {
            $data = $data->where('id_pemohon', $user->id);
        }
        return Datatables::of($data)
        ->editColumn('info', function($data)
        {
            $pemohon = User::find($data->id_pemohon);
            $bidang = UserBidang::find($data->bidang);
            try {

                return [
                    'pemohon' => $pemohon,
                    'bidang' => $bidang,
                ];
            } catch(Exception $e) {
                return null;
            }
        })
        ->editColumn('flow_name', function($data)
        {
            $fn = Flow::find($data->flow);
            return $fn['flow_name'] ?? '';
        })
        ->editColumn('has_action', function($data) use($user)
        {
            $fn = Flow::find($data->flow);
            $role = $fn['role'] ?? '';
            if($role == $user->role){
                $acts = [];
                if($fn['can_edit']){
                    $acts[] = 'edit';
                } else {
                    if($fn['can_decline']){
                        $acts[] = 'decline';
                    }
                    $acts[] = 'acc';
                }
                if($fn['input_penyedia']== '1'){
                    $acts[] = 'input_penyedia';
                }
                return $acts;
            } else {
                return false;
            }
        })
        ->toJson();
    }

    public function pengajuandetailDataTables(Request $request){
        $data = PengajuanDetail::where('draftcode', $request->draftcode)->get();
        return Datatables::of($data)->toJson();
    }

    public function stockgudangDataTables(Request $request){
        $user = Auth::user();
        $gudang_id = $request->gudang_id;
        if($gudang_id == 'all'){
            $gudang_id = Gudang::where('aktif', 1)->get()->pluck('id');
        } else {
            $gudang_id = [$gudang_id];
        }

        $data = DB::table(DB::raw('stock_gudang sg'))
        ->select('sg.gudang_id','sg.barang_id',
        DB::raw('SUM(sg.stock) as stock'),DB::raw('SUM(sg.rencana) as rencana'),DB::raw('GROUP_CONCAT(sg.draftcode) as draftcodes'),
        'mb.uraian','mb.satuan','mb.harga_maksimum')
        ->leftJoin(DB::raw('m_barang mb'),'sg.barang_id','=','mb.id')
        ->whereIn('sg.gudang_id', $gudang_id)->where('sg.stock','>',0)
        ->groupBy('sg.barang_id', 'sg.gudang_id','mb.uraian','mb.satuan','mb.harga_maksimum');

        if(isset($data)){
            return Datatables::of($data)
            ->editColumn('fifo', function($data)
            {
                $list = explode(',',$data->draftcodes);
                if(count($list) >  1){
                    $arr = [];
                    foreach ($list as $dc){
                        $fn = StockGudang::where('draftcode', $dc)->where('barang_id', $data->barang_id)
                        ->where('gudang_id', $data->gudang_id)->orderBy('created_at', 'asc')->first();
                        $arr[$dc] = [
                            'rencana' => $fn->rencana,
                            'stock' => $fn->stock,
                            'tanggal' => $fn->created_at->format('d-m-Y H:i')
                        ];

                    }
                    return $arr;
                } else {
                    return null;
                }
            })
            ->addColumn('nama_gudang', function($data)
            {
                $nama_gudang = Gudang::where('id', $data->gudang_id)->pluck('nama_gudang');
                return $nama_gudang[0] ?? '';
            })
            ->toJson();
        } else {
            return null;
        }
    }

    public function grafikDashboard(Request $request){
        $in =  Pengajuan::select(DB::raw('SUM(total_keseluruhan) pengajuan, YEAR(tgl_disetujui) year, MONTH(tgl_disetujui) month'))
        ->whereNotNull('tgl_disetujui')
        ->groupby('year','month')
        ->get();
        return response()->json(compact('in'));
    }
}
