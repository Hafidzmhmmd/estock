<?php

use Illuminate\Database\Seeder;
use App\Barang;
use App\SubSubKelompok;
use App\Gudang;
class PengajuanSeeder extends Seeder
{
     /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tabel = 'pengajuan';
        $data = [
           [
            'draftcode' => 'AAABBB',
            'id_pemohon' => 4,
            'bidang' => 1,
            'status' => 'F',
            'nama_penyedia' => "CV. KEMHIL INDOTAMA",
            'faktur' => null,
            'total_keseluruhan' => 1446000,
            'tgl_pengajuan' => DateTime::createFromFormat('d/m/Y', '4/9/2023'),
            'tgl_disetujui' => DateTime::createFromFormat('d/m/Y', '10/10/2023'),
            'tgl_konfirmasibeli' => DateTime::createFromFormat('d/m/Y', '10/10/2023'),
            'tgl_selesai' => DateTime::createFromFormat('d/m/Y', '10/10/2023'),
            'tgl_tolak' => null,
            'flow' => 8,
            'created_at' => DateTime::createFromFormat('d/m/Y', date('d/m/Y')),
            'updated_at' => null,
            'detail' => [
                ['identifier'=>'1010302001000049','harga_satuan'=>'66000','jumlah_barang'=>'2'],
                ['identifier'=>'1010302001000058','harga_satuan'=>'9600','jumlah_barang'=>'12'],
                ['identifier'=>'1010302004000021','harga_satuan'=>'22200','jumlah_barang'=>'2'],
                ['identifier'=>'1010301001000132','harga_satuan'=>'4200','jumlah_barang'=>'12'],
                ['identifier'=>'1010304004000224','harga_satuan'=>'540000','jumlah_barang'=>'1'],
                ['identifier'=>'1010304004000223','harga_satuan'=>'540000','jumlah_barang'=>'1'],
                ['identifier'=>'1010301004000007','harga_satuan'=>'3000','jumlah_barang'=>'8'],
            ],
           ],
           [
            'draftcode' => 'CCCDDD',
            'id_pemohon' => 4,
            'bidang' => 1,
            'status' => 'F',
            'nama_penyedia' => "CV. KEMHIL INDOTAMA",
            'faktur' => null,
            'total_keseluruhan' => 1000000,
            'tgl_pengajuan' => DateTime::createFromFormat('d/m/Y', '4/9/2023'),
            'tgl_disetujui' => DateTime::createFromFormat('d/m/Y', '09/10/2023'),
            'tgl_konfirmasibeli' => DateTime::createFromFormat('d/m/Y', '09/10/2023'),
            'tgl_selesai' => DateTime::createFromFormat('d/m/Y', '09/10/2023'),
            'tgl_tolak' => null,
            'flow' => 8,
            'created_at' => DateTime::createFromFormat('d/m/Y', date('d/m/Y')),
            'updated_at' => null,
            'detail' => [
                ['identifier'=>'1010304004000222','harga_satuan'=>'582000','jumlah_barang'=>'1'],
                ['identifier'=>'1010302001000021','harga_satuan'=>'66000','jumlah_barang'=>'3'],
                ['identifier'=>'1010302004000031','harga_satuan'=>'40800','jumlah_barang'=>'1'],
                ['identifier'=>'1010301003000001','harga_satuan'=>'2400','jumlah_barang'=>'3'],
                ['identifier'=>'1010301006000120','harga_satuan'=>'3000','jumlah_barang'=>'20'],
                ['identifier'=>'1010301999000110','harga_satuan'=>'24000','jumlah_barang'=>'3'],
                ['identifier'=>'1010301001000188','harga_satuan'=>'20000','jumlah_barang'=>'2'],
            ],
           ],
           [
            'draftcode' => 'EEEFFF',
            'id_pemohon' => 4,
            'bidang' => 1,
            'status' => 'F',
            'nama_penyedia' => "CV. DUTA PUTRA BANGSA",
            'faktur' => null,
            'total_keseluruhan' => 997200,
            'tgl_pengajuan' => DateTime::createFromFormat('d/m/Y', '2/10/2023'),
            'tgl_disetujui' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_konfirmasibeli' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_selesai' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_tolak' => null,
            'flow' => 8,
            'created_at' => DateTime::createFromFormat('d/m/Y', date('d/m/Y')),
            'updated_at' => null,
            'detail' => [
                ['identifier'=>'1010301003000016','harga_satuan'=>'17400','jumlah_barang'=>'6'],
                ['identifier'=>'1010301003000017','harga_satuan'=>'12000','jumlah_barang'=>'6'],
                ['identifier'=>'1010301003000018','harga_satuan'=>'7200','jumlah_barang'=>'6'],
                ['identifier'=>'1010301003000021','harga_satuan'=>'4800','jumlah_barang'=>'6'],
                ['identifier'=>'1010301003000019','harga_satuan'=>'3600','jumlah_barang'=>'5'],
                ['identifier'=>'1010306010000013','harga_satuan'=>'18000','jumlah_barang'=>'3'],
                ['identifier'=>'1010306010000014','harga_satuan'=>'30000','jumlah_barang'=>'3'],
                ['identifier'=>'1010304010000003','harga_satuan'=>'42000','jumlah_barang'=>'4'],
                ['identifier'=>'1010304006000027','harga_satuan'=>'85200','jumlah_barang'=>'4'],
                ['identifier'=>'1010306001000001','harga_satuan'=>'78000','jumlah_barang'=>'1'],
            ],
           ],
           [
            'draftcode' => 'GGGHHH',
            'id_pemohon' => 4,
            'bidang' => 1,
            'status' => 'F',
            'nama_penyedia' => "CV. RAYYA MITRA ASIA",
            'faktur' => null,
            'total_keseluruhan' => 1995200,
            'tgl_pengajuan' => DateTime::createFromFormat('d/m/Y', '4/10/2023'),
            'tgl_disetujui' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_konfirmasibeli' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_selesai' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_tolak' => null,
            'flow' => 8,
            'created_at' => DateTime::createFromFormat('d/m/Y', date('d/m/Y')),
            'updated_at' => null,
            'detail' => [
                ['identifier'=>'1010302001000021','harga_satuan'=>'66000','jumlah_barang'=>'5'],
                ['identifier'=>'1010302001000020','harga_satuan'=>'72000','jumlah_barang'=>'5'],
                ['identifier'=>'1010301001000015','harga_satuan'=>'15400','jumlah_barang'=>'20'],
                ['identifier'=>'1010301001000016','harga_satuan'=>'15400','jumlah_barang'=>'15'],
                ['identifier'=>'1010301001000056','harga_satuan'=>'15400','jumlah_barang'=>'15'],
                ['identifier'=>'1010304010000010','harga_satuan'=>'267600','jumlah_barang'=>'2'],
            ],
           ],
           [
            'draftcode' => 'IIIJJJ',
            'id_pemohon' => 4,
            'bidang' => 1,
            'status' => 'F',
            'nama_penyedia' => "CV. SABILA JAYA PERKASA",
            'faktur' => null,
            'total_keseluruhan' => 1038000,
            'tgl_pengajuan' => DateTime::createFromFormat('d/m/Y', '9/10/2023'),
            'tgl_disetujui' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_konfirmasibeli' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_selesai' => DateTime::createFromFormat('d/m/Y', '30/10/2023'),
            'tgl_tolak' => null,
            'flow' => 8,
            'created_at' => DateTime::createFromFormat('d/m/Y', date('d/m/Y')),
            'updated_at' => null,
            'detail' => [
                ['identifier'=>'1010301001000064','harga_satuan'=>'4200','jumlah_barang'=>'25'],
                ['identifier'=>'1010301001000067','harga_satuan'=>'4200','jumlah_barang'=>'25'],
                ['identifier'=>'1010301999000110','harga_satuan'=>'24000','jumlah_barang'=>'5'],
                ['identifier'=>'1010301999000100','harga_satuan'=>'12000','jumlah_barang'=>'10'],
                ['identifier'=>'1010302001000025','harga_satuan'=>'117600','jumlah_barang'=>'5'],
            ],
           ],
        ];
        $stock_id = 0;
        $riwayat_id = 0;
        foreach($data as $index => $d){
            $row = [
                'draftcode' => $d['draftcode'],
                'id_pemohon' => $d['id_pemohon'],
                'bidang' => $d['bidang'],
                'status' => $d['status'],
                'nama_penyedia' => $d['nama_penyedia'],
                'faktur' => $d['faktur'],
                'total_keseluruhan' => $d['total_keseluruhan'],
                'tgl_pengajuan' => $d['tgl_pengajuan'],
                'tgl_disetujui' => $d['tgl_disetujui'],
                'tgl_konfirmasibeli' => $d['tgl_konfirmasibeli'],
                'tgl_selesai' => $d['tgl_selesai'],
                'tgl_tolak' => $d['tgl_tolak'],
                'flow' => $d['flow'],
                'created_at' => $d['created_at'],
                'updated_at' => $d['updated_at'],
            ];
            DB::table($tabel)->insert($row);
            foreach($d['detail'] as $detail){
                $barang = Barang::where('identifier', $detail['identifier'])->first();
                if($barang){
                    $subsubkel = SubSubKelompok::where([
                        ['gol_id', '=', $barang->gol_id],
                        ['bid_id', '=', $barang->bid_id],
                        ['kel_id', '=', $barang->kel_id],
                        ['subkel_id', '=', $barang->subkel_id]
                    ])->first();
                    $det = [
                        'draftcode' => $d['draftcode'],
                        'id_barang' => $barang->id,
                        'subkel' => $subsubkel->sub_subkelompok,
                        'nama_barang' => $barang->uraian,
                        'harga_maksimum' => 0,
                        'satuan' => $barang->satuan,
                        'harga_satuan' => $detail['harga_satuan'],
                        'jumlah_barang' => $detail['jumlah_barang'],
                        'total_harga' => intval($detail['harga_satuan']) * intval($detail['jumlah_barang']),
                        'created_at' => $d['tgl_disetujui'],
                        'updated_at' => $d['tgl_disetujui'],
                    ];
                    DB::table("pengajuan_detail")->insert($det);

                    $gudang = Gudang::where('bidang_id',$d['bidang'])->first();
                    $stock = [
                        'gudang_id' => $gudang->id,
                        'barang_id' => $barang->id,
                        'rencana' => 0,
                        'stock' => $detail['jumlah_barang'],
                        'draftcode' => $d['draftcode'],
                        'created_at' => $d['tgl_disetujui'],
                        'updated_at' => $d['tgl_disetujui'],
                    ];
                    DB::table("stock_gudang")->insert($stock);
                    $stock_id ++;

                    $riwayat = [
                        'arah' => 2,
                        'userid' => 2,
                        'draftcode' => $d['draftcode'],
                        'gudangid' => $gudang->id,
                        'bidangid' => $d['bidang'],
                        'created_at' => $d['tgl_disetujui'],
                        'updated_at' => $d['tgl_disetujui'],
                    ];
                    DB::table("riwayat_gudang")->insert($riwayat);
                    $riwayat_id ++;

                    $log = [
                        'gudangid' => $gudang->id,
                        'barangid' => $barang->id,
                        'before' => $detail['jumlah_barang'],
                        'after' => 0,
                        'draftcode' => $d['draftcode'],
                        'stock_id' => $stock_id,
                        'riwayat_id' => $riwayat_id,
                        'keterangan' => 'konfirmasi pembelian',
                        'jumlah' => $detail['jumlah_barang'],
                        'status' => 1
                    ];
                    DB::table("stock_change_log")->insert($log);
                }

            }
        }
    }
}
