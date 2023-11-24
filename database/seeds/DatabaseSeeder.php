<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            //master data
            MasterGolonganBarangSeeder::class,
            MasterBidangBarangSeeder::class,
            MasterKelompokBarangSeeder::class,
            MasterSubKelompokBarangSeeder::class,
            MasterSubSubKelompokBarangSeeder::class,
            MasterBarangSeeder::class,

            //userDefault
            UsersSeeder::class,
            UserRoleSeeder::class,
            UserBidangSeeder::class,
            GudangSeeder::class,

            //access
            MenuSeeder::class,

            //flow
            FlowSeeder::class,

            //pengajuan
            PengajuanSeeder::class,
        ]);
        //user
        // DB::table('users')->insert([
        //     'name' => 'Bidang 1',
        //     'username' => 'bidang1',
        //     'password' => bcrypt('password'),
        //     'role' => 1,
        // ]);
    }
}
