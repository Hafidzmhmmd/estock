<!DOCTYPE html>
<html>
<head>
	<title>LAPORAN RINCIAN BARANG PERSEDIAAN</title>
</head>
<style>
    .center {
        text-align: center;
        margin: 0;
    }
    .table{
        width: 100%;
    }
    .table, .table th, .table td {
        border: 1px solid black;
        border-collapse: collapse;
    }

    .table th, .table td{
        padding: 5px;
    }

    .table tr th {

    }
</style>
<body>
    <h3 class="center">LAPORAN RINCIAN BARANG PERSEDIAAN</h3>
    <p class="center">{{$dstart}} - {{$dend}}</p>
    <br>
    <table class="table" style="font-size:8pt">
        <thead>
          <tr>
            <th rowspan="2" style="width:15%">Kode Barang</th>
            <th rowspan="2" style="width:25%">Uraian</th>
            <th colspan="2">Nilai pada <br> {{$dstart}}</th>
            <th colspan="3">Mutasi</th>
            <th colspan="2">Nilai pada <br> {{$dend}}</th>
          </tr>
          <tr>
            <td>Jumlah</td>
            <td>Rupiah</td>
            <td>Masuk</td>
            <td>Keluar</td>
            <td>Jumlah</td>
            <td>Jumlah</td>
            <td>Rupiah</td>
          </tr>
        </thead>
        <tbody>
         @foreach ($subsubkel as $sub)
            @php
                $row = [];

                $allRup = 0;
                $allRupEnd = 0;
                foreach ($sub->barang as $index => $barang) {
                    if ($index == 0){
                        $row[] = "
                        <tr>
                            <td></td>
                            <td style='color:blue'>$sub->sub_subkelompok</td>
                            <th style='color:blue' colspan='2'>nilai</th>
                            <th style='color:blue' colspan='3'></th>
                            <th style='color:blue' colspan='2'>nilai</th>
                        </tr>
                        ";
                    }

                    $jml = 0;
                    $rup = 0;
                    $masuk = 0;
                    $keluar = 0;
                    foreach ($b_data as $b) {
                        if($b->id_barang == $barang->id){
                            $jml = $b->sisa;
                            $rup = $b->sisa_harga;
                            $masuk = $b->jumlah;
                            $keluar = $b->ambil;

                            $allRup += $b->sisa_harga;
                        }
                    }
                    $aJml = 0;
                    $aRup = 0;
                    $aMasuk = 0;
                    $aKeluar = 0;
                    foreach ($a_data as $a) {
                        if($a->id_barang == $barang->id){
                            $aJml = $a->sisa;
                            $aRup = $a->sisa_harga;
                            $aMasuk = $a->jumlah;
                            $aKeluar = $a->ambil;

                            $allRupEnd += $a->sisa_harga;
                        }
                    }

                    $tMasuk = $aMasuk - $masuk ;
                    $tKeluar = $aKeluar - $keluar;
                    $tJumlah = $tMasuk - $tKeluar;

                    $row[] = "
                    <tr>
                        <td>$barang->kode</td>
                        <td>$barang->uraian</td>
                        <td>$jml</td>
                        <td>$rup</td>
                        <td>$tMasuk</td>
                        <td>$tKeluar</td>
                        <td>$tJumlah</td>
                        <td>$aJml</td>
                        <td>$aRup</td>
                    </tr>
                    ";
                }


                $row[0] = "
                    <tr>
                        <td></td>
                        <td style='color:blue'>$sub->sub_subkelompok</td>
                        <th style='color:blue' colspan='2'>$allRup</th>
                        <th style='color:blue' colspan='3'></th>
                        <th style='color:blue' colspan='2'>$allRupEnd</th>
                    </tr>
                ";
            @endphp
            @foreach ($row as $r)
                {!! $r !!}
            @endforeach
         @endforeach
        </tbody>
      </table>
</body>
</html>
