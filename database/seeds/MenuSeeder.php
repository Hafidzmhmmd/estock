<?php

use Illuminate\Database\Seeder;
use App\User;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'menu';
        $data = [
            [
                'title' => 'Dashboard',
                'group' => 0,
                'pathname' => 'dashboard',
                'has_sub' => 0,
                'urutan' => 1,
                'access_role' => [1,2,3,4,5,6],
            ],
            [
                'title' => 'Pengajuan',
                'group' => 0,
                'pathname' => 'pengajuan',
                'has_sub' => 1,
                'urutan' => 2,
                'access_role' => [1],
            ],
            [
                'title' => 'Gudang',
                'group' => 0,
                'pathname' => 'gudang.index',
                'has_sub' => 0,
                'urutan' => 3,
                'access_role' => [1,3],
            ],
            [
                'title' => 'Laporan',
                'group' => 0,
                'pathname' => 'laporan',
                'has_sub' => 1,
                'urutan' => 4,
                'access_role' => [3],
            ],
            [
                'title' => 'Management',
                'group' => 0,
                'pathname' => 'data',
                'has_sub' => 0,
                'urutan' => 5,
                'access_role' => [3],
            ],
            [
                'title' => 'Pembelian Baru',
                'group' => 2,
                'pathname' => 'pembelian',
                'has_sub' => 0,
                'urutan' => 6,
                'access_role' => [1],
            ],
            [
                'title' => 'Daftar Pembelian',
                'group' => 2,
                'pathname' => 'daftarpembelian',
                'has_sub' => 0,
                'urutan' => 7,
                'access_role' => [1],
            ],
            [
                'title' => 'Opname Stock',
                'group' => 4,
                'pathname' => 'opname',
                'has_sub' => 0,
                'urutan' => 8,
                'access_role' => [3],
            ],
            [
                'title' => 'Buku Persediaan',
                'group' => 4,
                'pathname' => 'bukupersediaan',
                'has_sub' => 0,
                'urutan' => 9,
                'access_role' => [3],
            ],
            [
                'title' => 'Barang',
                'group' => 5,
                'pathname' => 'barang',
                'has_sub' => 0,
                'urutan' => 10,
                'access_role' => [3],
            ],
            [
                'title' => 'Users',
                'group' => 5,
                'pathname' => 'userapp',
                'has_sub' => 0,
                'urutan' => 11,
                'access_role' => [3],
            ],
            [
                'title' => 'Golongan [Barang]',
                'group' => 5,
                'pathname' => 'golongan',
                'has_sub' => 0,
                'urutan' => 12,
                'access_role' => [3],
            ],
            [
                'title' => 'Bidang [Barang]',
                'group' => 5,
                'pathname' => 'bidang',
                'has_sub' => 0,
                'urutan' => 13,
                'access_role' => [3],
            ],
            [
                'title' => 'Kelompok [Barang]',
                'group' => 5,
                'pathname' => 'kelompok',
                'has_sub' => 0,
                'urutan' => 14,
                'access_role' => [3],
            ],
        ];

        foreach($data as $index => $d){
            $row = [
                'title' => $d['title'],
                'group' => $d['group'],
                'pathname' => $d['pathname'],
                'has_sub' => $d['has_sub'],
                'urutan' => $d['urutan'],
            ];
            DB::table($tabel)->insert( $row );
            $users = User::whereIn('role', $d['access_role'])->get();
            foreach($users as $u){
                $acc = [
                    'menuid' => $index+1,
                    'userid' => $u->id,
                ];
                DB::table("menu_access")->insert( $acc );
            }
            foreach($d['access_role'] as $role){
                $rm = [
                    'role' => $role,
                    'menuid' => $index+1
                ];
                DB::table("role_menu")->insert( $rm );
            }
        }
    }
}
