<?php

use Illuminate\Database\Seeder;
class UserRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'user_role';
        $data = [
            [
                'nama_role' => 'Pegawai',
            ],
            [
                'nama_role' => 'PPK',
            ],
            [
                'nama_role' => 'Pengelola BMN',
            ],
            [
                'nama_role' => 'Admin',
            ],
            [
                'nama_role' => 'Superuser',
            ],
            [
                'nama_role' => 'PPSPM',
            ],
        ];
        DB::table($tabel)->insert($data);
    }
}
