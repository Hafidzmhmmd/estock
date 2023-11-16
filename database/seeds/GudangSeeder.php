<?php

use Illuminate\Database\Seeder;
class GudangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'gudang';
        $data = [
            [
                'nama_gudang' => 'Gudang Bidang Satu',
                'bidang_id' => 1,
            ],
            [
                'nama_gudang' => 'Gudang Bidang Dua',
                'bidang_id' => 2,
            ],
            [
                'nama_gudang' => 'Gudang Bidang Tiga',
                'bidang_id' => 3,
            ],
            [
                'nama_gudang' => 'Gudang Bidang Empat',
                'bidang_id' => 4,
            ],
            [
                'nama_gudang' => 'Gudang Bidang Lima',
                'bidang_id' => 5,
            ],
            [
                'nama_gudang' => 'Gudang Sub Bagian Satu',
                'bidang_id' => 6,
            ],
            [
                'nama_gudang' => 'Gudang Sub Bagian Dua',
                'bidang_id' => 7,
            ],
            [
                'nama_gudang' => 'Gudang Sub Bagian Tiga',
                'bidang_id' => 8,
            ],
        ];
        DB::table($tabel)->insert($data);
    }
}
