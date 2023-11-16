<?php

use Illuminate\Database\Seeder;
class MasterGolonganBarangSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'm_gol_barang';
        $data = [
            [
                "gol_id"=>"1",
                "golongan"=>"PERSEDIAAN"
            ]
        ];
        DB::table($tabel)->insert($data);
    }
}
