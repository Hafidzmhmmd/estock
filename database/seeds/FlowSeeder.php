<?php

use Illuminate\Database\Seeder;
class FlowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'flow';
        $data = [
            [
                "flow_name" => "pengajuan ditolak",
                "status" => "C",
                "step" => 0,
                "next_flow" => 0,
                "decline" => 0,
                "role" => null,
                "update_date" => "tgl_tolak",
                "proses_rencana" => 0,
                "proses_stock" => 0,
                "can_decline" => 0,
                "can_edit" => 0,
                "input_penyedia" => 0,
            ],
            [
                "flow_name" => "Pembuatan Pengajuan",
                "status" => "D",
                "step" => 1,
                "next_flow" => 3,
                "decline" => 1,
                "role" => 1,
                "update_date" => "",
                "proses_rencana" => 0,
                "proses_stock" => 0,
                "can_decline" => 0,
                "can_edit" => 1,
                "input_penyedia" => 0,
            ],
            [
                "flow_name" => "Menunggu Persetujuan PPK",
                "status" => "P",
                "step" => "2",
                "next_flow" => 4,
                "decline" => 1,
                "role" => "2",
                "update_date" => "tgl_pengajuan",
                "proses_rencana" => 0,
                "proses_stock" => 0,
                "can_decline" => 1,
                "can_edit" => 0,
                "input_penyedia" => 0,
            ],
            [
                "flow_name" => "Proses Pembelian Barang",
                "status" => "A",
                "step" => "3",
                "next_flow" => 5,
                "decline" => 0,
                "role" => 1,
                "update_date" => "tgl_disetujui",
                "proses_rencana" => 1,
                "proses_stock" => 0,
                "can_decline" => 0,
                "can_edit" => 0,
                "input_penyedia" => 1,
            ],
            [
                "flow_name" => "Proses Verifikasi Pembelian Oleh PPK",
                "status" => "A",
                "step" => "4",
                "next_flow" => 7,
                "decline" => 1,
                "role" => "2",
                "update_date" => "tgl_konfirmasibeli",
                "proses_rencana" => 0,
                "proses_stock" => 0,
                "can_decline" => 1,
                "can_edit" => 0,
                "input_penyedia" => 2,
            ],
            [
                "flow_name" => "Proses Verifikasi PPSPM",
                "status" => "A",
                "step" => "5",
                "next_flow" => 7,
                "decline" => 1,
                "role" => "6",
                "update_date" => null,
                "proses_rencana" => 0,
                "proses_stock" => 0,
                "can_decline" => 1,
                "can_edit" => 0,
                "input_penyedia" => 2,
            ],
            [
                "flow_name" => "Proses Verifikasi Pengelola BMN",
                "status" => "A",
                "step" => "7",
                "next_flow" => 8,
                "decline" => 1,
                "role" => "3",
                "update_date" => null,
                "proses_rencana" => 0,
                "proses_stock" => 0,
                "can_decline" => 1,
                "can_edit" => 0,
                "input_penyedia" => 2,
            ],
            [
                "flow_name" => "Selesai",
                "status" => "F",
                "step" => "8",
                "next_flow" => null,
                "decline" => 0,
                "role" => null,
                "update_date" => "tgl_selesai",
                "proses_rencana" => 0,
                "proses_stock" => 1,
                "can_decline" => 0,
                "can_edit" => 0,
                "input_penyedia" => 2,
            ],
        ];
        DB::table($tabel)->insert($data);
    }
}
