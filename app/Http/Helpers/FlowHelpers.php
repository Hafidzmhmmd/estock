<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Flow;
use App\Pengajuan;
use App\Progress;
use DateTime;
use App\Http\Helpers\StockHelpers;
use App\Http\Helpers\RiwayatHelpers;

class FlowHelpers {
    public static function nextFlow($draftcode){
        $flow = (object) [
            'next' => false,
            'flowid' => null,
            'proses' => null,
            'status' => null,
            'err' => 'pengajuan tidak ditemukan'
        ];
        $current = Pengajuan::where('draftcode', $draftcode);
        if($current->count()){
            $user = Auth::user();
            $current = $current->first();
            $crrFlow = Flow::find($current->flow);
            if($user->role == $crrFlow->role){
                $nextFlow = Flow::find($crrFlow->next_flow);
                $current->flow = $nextFlow->id;
                $current->status = $nextFlow->status;
                if(!empty($nextFlow->update_date)){
                    $current->{$nextFlow->update_date} = new DateTime();
                }
                if($nextFlow->proses_rencana){
                    $rencana = StockHelpers::addStockRencana($current);
                    if(!$rencana['status']){
                        $flow->err = $rencana['msg'];
                        return $flow;
                    } else {
                        $log = RiwayatHelpers::log((object)[
                            'arah' => config('app.flow.rencana'),
                            'draftcode' => $draftcode
                        ], $rencana['logs']);
                    }
                }
                if($nextFlow->proses_stock){
                    $stock = StockHelpers::setStock($current);
                    if(!$stock['status']){
                        $flow->err = $stock['msg'];
                        return $flow;
                    } else {
                        $log = RiwayatHelpers::log((object)[
                            'arah' => config('app.flow.stock'),
                            'draftcode' => $draftcode
                        ], $stock['logs']);
                    }
                }
                if($current->save()){
                    $rec = new Progress;
                    $rec->draftcode = $draftcode;
                    $rec->before = $crrFlow->id;
                    $rec->after = $nextFlow->id;
                    $rec->actor = $user->id;
                    $rec->save();

                    $flow->next = true;
                    $flow->flowid = $current->flow;
                    $flow->proses = $nextFlow->flow_name;
                    $flow->status = $current->status;
                }
            } else {
                $flow->err = 'invalid access';
            }
        }
        return $flow;
    }

    public static function decline($drafcode){
        $flow = (object) [
            'decline' => false,
            'err' => 'pengajuan tidak ditemukan'
        ];
        $current = Pengajuan::where('draftcode', $draftcode);
        if($current->count()){
            $user = Auth::user();
            $current = $current->first();
            $crrFlow = Flow::find($current->flow);
            if($user->role == $crrFlow->role && $crrFlow->can_decline){
                $declineFlow = Flow::find($crrFlow->decline);
                $current->flow = $declineFlow->id;
                $current->status = $declineFlow->status;
                if(!empty($declineFlow->update_date)){
                    $current->{$nextFlow->update_date} = new DateTime();
                }
                if($current->save()){
                    $rec = new Progress;
                    $rec->draftcode = $draftcode;
                    $rec->before = $crrFlow->id;
                    $rec->after = $nextFlow->id;
                    $rec->actor = $user->id;
                    $rec->save();

                    $flow->decline = true;
                }
            } else {
                $flow->err = 'invalid access';
            }
        }
        return $flow;
    }
}
