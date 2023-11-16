<?php

use Illuminate\Database\Seeder;
class MasterBidangBarangSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'm_bid_barang';
        $data = [
            [
                "bid_id"=>"01",
                "gol_id"=>"1",
                "bidang"=>"BARANG HABIS PAKAI"
            ]
        ];
        DB::table($tabel)->insert($data);
    }
}
