<?php

use Illuminate\Database\Seeder;
class MasterSubKelompokBarangSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'm_subkel_barang';
        $data = [
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'ALAT TULIS KANTOR'],
            ['subkel_id'=>'02','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'KERTAS DAN COVER'],
            ['subkel_id'=>'03','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'BAHAN CETAK'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'BAHAN KOMPUTER'],
            ['subkel_id'=>'05','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'PERABOT KANTOR'],
            ['subkel_id'=>'06','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'ALAT LISTRIK'],
            ['subkel_id'=>'07','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'PERLENGKAPAN DINAS'],
            ['subkel_id'=>'09','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'PERLENGKAPAN PENUNJANG KEGIATAN KANTOR'],
            ['subkel_id'=>'99','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'ALAT/BAHAN UNTUK KEGIATAN KANTOR LAINNYA'],
            ['subkel_id'=>'01','kel_id'=>'05','bid_id'=>'01','gol_id'=>'1','subkelompok'=>'PERSEDIAAN UNTUK DIJUAL/DISERAHKAN KEPADA'],
        ];
        DB::table($tabel)->insert($data);
    }
}
