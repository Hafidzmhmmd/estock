<?php

use Illuminate\Database\Seeder;
class UserBidangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'user_bidang';
        $data = [
            [
                'nama_bidang' => 'Bidang Satu',
            ],
            [
                'nama_bidang' => 'Bidang Dua',
            ],
            [
                'nama_bidang' => 'Bidang Tiga',
            ],
            [
                'nama_bidang' => 'Bidang Empat',
            ],
            [
                'nama_bidang' => 'Bidang Lima',
            ],
            [
                'nama_bidang' => 'Sub Bagian Satu',
            ],
            [
                'nama_bidang' => 'Sub Bagian Dua',
            ],
            [
                'nama_bidang' => 'Sub Bagian Tiga',
            ],
        ];
        DB::table($tabel)->insert($data);
    }
}
