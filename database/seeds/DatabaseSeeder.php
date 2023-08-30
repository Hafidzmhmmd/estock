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
        DB::table('users')->insert([
            'name' => 'Bidang 1',
            'username' => 'bidang1',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);
    }
}
