<?php

use Illuminate\Database\Seeder;
class MasterSubSubKelompokBarangSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'm_sub_subkel_barang';
        $data = [
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'001','sub_subkelompok'=>'Alat Tulis'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'002','sub_subkelompok'=>'Tinta Tulis, Tinta Stempel'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'003','sub_subkelompok'=>'Penjepit Kertas'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'004','sub_subkelompok'=>'Penghapus/Korektor'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'005','sub_subkelompok'=>'Buku Tulis'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'006','sub_subkelompok'=>'Ordner Dan Map'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'007','sub_subkelompok'=>'Penggaris'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'008','sub_subkelompok'=>'Cutter (Alat Tulis Kantor)'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'009','sub_subkelompok'=>'Pita Mesin Ketik'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'010','sub_subkelompok'=>'Alat Perekat'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'012','sub_subkelompok'=>'Staples'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'013','sub_subkelompok'=>'Isi Staples'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'014','sub_subkelompok'=>'Barang Cetakan'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'015','sub_subkelompok'=>'Seminar Kit'],
            ['subkel_id'=>'01','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'999','sub_subkelompok'=>'Alat Tulis Kantor Lainnya'],
            ['subkel_id'=>'02','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'001','sub_subkelompok'=>'Kertas HVS'],
            ['subkel_id'=>'02','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'002','sub_subkelompok'=>'Berbagai Kertas'],
            ['subkel_id'=>'02','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'003','sub_subkelompok'=>'Kertas Cover'],
            ['subkel_id'=>'02','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'004','sub_subkelompok'=>'Amplop'],
            ['subkel_id'=>'02','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'005','sub_subkelompok'=>'Kop Surat'],
            ['subkel_id'=>'02','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'999','sub_subkelompok'=>'Kertas Dan Cover Lainnya'],
            ['subkel_id'=>'03','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'999','sub_subkelompok'=>'Bahan Cetak Lainnya'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'001','sub_subkelompok'=>'Continuous Form'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'003','sub_subkelompok'=>'Pita Printer'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'004','sub_subkelompok'=>'Tinta/Toner Printer'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'005','sub_subkelompok'=>'Disket'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'006','sub_subkelompok'=>'USB/Flash Disk'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'008','sub_subkelompok'=>'CD/DVD Drive'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'010','sub_subkelompok'=>'Mouse'],
            ['subkel_id'=>'04','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'999','sub_subkelompok'=>'Bahan Komputer Lainnya'],
            ['subkel_id'=>'05','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'001','sub_subkelompok'=>'Sapu Dan Sikat'],
            ['subkel_id'=>'05','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'999','sub_subkelompok'=>'Perabot Kantor Lainnya'],
            ['subkel_id'=>'06','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'001','sub_subkelompok'=>'Kabel Listrik'],
            ['subkel_id'=>'06','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'002','sub_subkelompok'=>'Lampu Listrik'],
            ['subkel_id'=>'06','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'010','sub_subkelompok'=>'Batu Baterai'],
            ['subkel_id'=>'07','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'002','sub_subkelompok'=>'Penutup Kepala'],
            ['subkel_id'=>'07','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'007','sub_subkelompok'=>'Perlengkapan Lapangan'],
            ['subkel_id'=>'09','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'999','sub_subkelompok'=>'Perlengkapan Penunjang Kegiatan Kantor Lainnya'],
            ['subkel_id'=>'99','kel_id'=>'03','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'999','sub_subkelompok'=>'Alat/bahan Untuk Kegiatan Kantor Lainnya'],
            ['subkel_id'=>'01','kel_id'=>'05','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'001','sub_subkelompok'=>'Pita Cukai, Materai, Leges'],
            ['subkel_id'=>'01','kel_id'=>'05','bid_id'=>'01','gol_id'=>'1','sub_subkel_id'=>'008','sub_subkelompok'=>'Barang Persediaan'],
        ];
        DB::table($tabel)->insert($data);
    }
}
