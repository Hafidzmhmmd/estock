<?php

use Illuminate\Database\Seeder;
class MasterKelompokBarangSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'm_kel_barang';
        $data = [
            [
                "kel_id"=>"03",
                "bid_id"=>"01",
                "gol_id"=>"1",
                "kelompok"=> "ALAT/BAHAN UNTUK KEGIATAN KANTOR"
            ],
            [
                "kel_id"=>"05",
                "bid_id"=>"01",
                "gol_id"=>"1",
                "kelompok"=> "PERSEDIAAN UNTUK DIJUAL/DISERAHKAN"
            ],
        ];
        DB::table($tabel)->insert($data);
    }
}
