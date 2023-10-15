<?php

namespace App\Http\Helpers;

use Illuminate\Support\Facades\Auth;
use App\Counter;
use App\Pengajuan;
use App\Progress;
use DateTime;
use App\Http\Helpers\StockHelpers;
use App\Http\Helpers\RiwayatHelpers;

class CounterHelpers {
    public static function NomorPengambilan()
    {
        $modul = 'pengambilan';
        $tahun = date("Y");
        $row = Counter::where('modul', $modul)->where('tahun', $tahun);
        if($row->count()){
            $row = $row->first();
            $row->counter = $row->counter + 1;
        } else {
            $row = new Counter;
            $row->modul = $modul;
            $row->counter = 1;
            $row->tahun = $tahun;
        }
        if($row->save()){
            $ct = $row->counter;
            $rBulan = self::numberToRomanRepresentation(date('n'));
            return "$ct/Pengambilan/$rBulan/$tahun";
        }
    }

    public static function numberToRomanRepresentation($number) {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}
