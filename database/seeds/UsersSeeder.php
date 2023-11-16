<?php

use Illuminate\Database\Seeder;
class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'users';
        $data = [
            [
                'name' => 'Admin PPK',
                'username' => 'ppk',
                'password' => bcrypt('password'),
                'role' => 2,
                'bidang' =>0,
            ],
            [
                'name' => 'Admin BMN',
                'username' => 'bmn',
                'password' => bcrypt('password'),
                'role' => 3,
                'bidang' =>0,
            ],
            [
                'name' => 'Admin PPSPM',
                'username' => 'ppspm',
                'password' => bcrypt('password'),
                'role' => 6,
                'bidang' =>0,
            ],
            [
                'name' => 'Username Bidang Satu',
                'username' => 'bidang1',
                'password' => bcrypt('password'),
                'role' => 1,
                'bidang' =>1,
            ],
            [
                'name' => 'Username Bidang Dua',
                'username' => 'bidang2',
                'password' => bcrypt('password'),
                'role' => 1,
                'bidang' =>2,
            ],
            [
                'name' => 'Username Bidang Tiga',
                'username' => 'bidang3',
                'password' => bcrypt('password'),
                'role' => 1,
                'bidang' =>3,
            ],
            [
                'name' => 'Username Bidang Empat',
                'username' => 'bidang4',
                'password' => bcrypt('password'),
                'role' => 1,
                'bidang' =>4,
            ],
        ];
        DB::table($tabel)->insert($data);
    }
}
