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
            <tr>
                <td></td>
                <td style="color:blue">{{$sub->sub_subkelompok}}</td>
                <th style="color:blue" colspan="2">nilai</th>
                <th style="color:blue" colspan="3"></th>
                <th style="color:blue" colspan="2">nilai</th>
            </tr>
            @foreach ($sub->barang as $barang)
                <tr>
                    <td>{{$barang->kode}}</td>
                    <td>{{$barang->uraian}}</td>
                    <td>Jumlah</td>
                    <td>Jumlah</td>
                    <td>Jumlah</td>
                    <td>Jumlah</td>
                    <td>Jumlah</td>
                    <td>Jumlah</td>
                    <td>Jumlah</td>
                </tr>
            @endforeach
         @endforeach
        </tbody>
      </table>
</body>
</html>
