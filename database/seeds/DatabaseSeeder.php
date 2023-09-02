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
        //user
        DB::table('users')->insert([
            'name' => 'Bidang 1',
            'username' => 'bidang1',
            'password' => bcrypt('password'),
            'role' => 1,
        ]);

        //gol_barang
        DB::table('m_gol_barang')->insert(
            ["gol_id"=>"01",
            "golongan"=>"Persediaan"
        ]);

        //bid_barang
        DB::table('m_bid_barang')->insert([
            "bid_id"=>"01",
            "gol_id"=>"01",
            "bidang"=>"Barang Pakai Habis"
        ]);

        //kel_barang
        DB::table('m_kel_barang')->insert([
            "kel_id"=>"03",
            "bid_id"=>"01",
            "gol_id"=>"01",
            "kelompok"=>"Alat/Bahan Untuk Kegiatan Kantor"
        ]);

        //subkel
        DB::table('m_subkel_barang')->insert([
            "subkel_id"=>"01",
            "kel_id"=>"03",
            "bid_id"=>"01",
            "gol_id"=>"01",
            "subkelompok"=>"Alat Tulis Kantor"
        ]);

        //subsubkel
        DB::table('m_sub_subkel_barang')->insert([
            "sub_subkel_id"=>"001",
            "subkel_id"=>"01",
            "kel_id"=>"03",
            "bid_id"=>"01",
            "gol_id"=>"01",
            "sub_subkelompok"=>"Alat Tulis Kantor"
        ]);

        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000022","uraian"=>"Pensil kayu Steadler","satuan"=>"Lusin"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000025","uraian"=>"Balliner Pilot type Medium, 1dus= 12 buah","satuan"=>"Dus"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000053","uraian"=>"Rautan Pensil Ukuran Besar","satuan"=>"Buah"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000063","uraian"=>"Ballpoint Faster C6","satuan"=>"Buah"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000064","uraian"=>"Ballpoint Kenko K-1 (Biru)","satuan"=>"Buah"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000067","uraian"=>"Ballpoint Kenko K-1 (Hitam)","satuan"=>"Buah"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000068","uraian"=>"Ballpoint Balliner (Hitam)","satuan"=>"Buah"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000069","uraian"=>"Ballpoint Balliner (Biru)","satuan"=>"Buah"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000070","uraian"=>"Ballpoint Balliner (Hijau)","satuan"=>"Buah"]);
        DB::table('m_barang')->insert(["gol_id"=>"01","bid_id"=>"01","kel_id"=>"03","subkel_id"=>"01","sub_subkel_id"=>"001","kode"=>"000074","uraian"=>"Ballpoint Kenko Easy Gel 0,5 Tinta Hitam","satuan"=>"Buah"]);
    }
}
