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
use App\GolonganBarang;
use App\User;
use App\UserBidang;
use App\Gudang;
use App\RoleUser;
use Exception;
use Yajra\Datatables\Datatables;

class DataController extends Controller
{
    public function dataBarang()
    {
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all();
        $data['bidang_barang'] = BidangBarang::all();
        $data['golongan_barang'] = GolonganBarang::all();
        return view('modules.data.barang', $data);
    }

    public function dataGolongan()
    {
        return view('modules.data.golongan');
    }

    public function dataBidang()
    {
        $data['golongan_barang'] = GolonganBarang::all();
        return view('modules.data.bidang', $data);
    }

    public function dataKelompok()
    {
        $data['subsubkelompok'] = SubSubKelompok::all();
        $data['kelompok_barang'] = KelompokBarang::all();
        $data['subkelompok'] = SubKelompok::all();
        $data['golongan_barang'] = GolonganBarang::all();
        $data['bidang_barang'] = BidangBarang::all();
        return view('modules.data.kelompok', $data);
    }

    public function dataUser()
    {
        $data['role'] = RoleUser::all();
        $data['bidang'] = UserBidang::all();
        return view('modules.user.index', $data);
    }

    public function userDataTables(){
        $data = User::select('users.*', 'user_role.nama_role', 'user_bidang.nama_bidang')
            ->join('user_role', 'users.role', '=', 'user_role.id')
            ->join('user_bidang', 'users.bidang', '=', 'user_bidang.id')
            ->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function golonganDataTables(){
        $data = GolonganBarang::get();
        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function bidangDataTables(){
        $data = BidangBarang::select('m_bid_barang.*', 'm_gol_barang.golongan')
            ->join('m_gol_barang', 'm_bid_barang.gol_id', '=', 'm_gol_barang.gol_id')
            ->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function kelompokDataTables(){
        $data = KelompokBarang::select('m_kel_barang.*', 'm_bid_barang.bidang', 'm_gol_barang.golongan')
            ->join('m_bid_barang', 'm_kel_barang.bid_id', '=', 'm_bid_barang.bid_id')
            ->join('m_gol_barang', 'm_kel_barang.gol_id', '=', 'm_gol_barang.gol_id')
            ->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function subkelompokDataTables(){
        $data = SubKelompok::select('m_subkel_barang.*', 'm_kel_barang.kelompok', 'm_bid_barang.bidang', 'm_gol_barang.golongan')
            ->join('m_kel_barang', 'm_subkel_barang.kel_id', '=', 'm_kel_barang.kel_id')
            ->join('m_bid_barang', 'm_subkel_barang.bid_id', '=', 'm_bid_barang.bid_id')
            ->join('m_gol_barang', 'm_subkel_barang.gol_id', '=', 'm_gol_barang.gol_id')
            ->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
    }

    public function subsubkelompokDataTables(){
        $data = SubSubKelompok::select('m_sub_subkel_barang.*', 'm_subkel_barang.subkelompok', 'm_kel_barang.kelompok', 'm_bid_barang.bidang', 'm_gol_barang.golongan')
            ->join('m_subkel_barang', 'm_sub_subkel_barang.subkel_id', '=', 'm_subkel_barang.subkel_id')
            ->join('m_kel_barang', 'm_sub_subkel_barang.kel_id', '=', 'm_kel_barang.kel_id')
            ->join('m_bid_barang', 'm_sub_subkel_barang.bid_id', '=', 'm_bid_barang.bid_id')
            ->join('m_gol_barang', 'm_sub_subkel_barang.gol_id', '=', 'm_gol_barang.gol_id')
            ->get();

        return DataTables::of($data)->addIndexColumn()->make(true);
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
            if(!empty($request->srch)){
                $instance->where('uraian', 'like', "%$request->srch%");
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
