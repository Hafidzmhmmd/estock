<!DOCTYPE html>
<html>
<head>
	<title>{{$detail->draftcode}}</title>
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
</style>
<body>
    <h2 class="center">BUKTI PENGAMBILAN BARANG</h2>
    <h4 class="center">Nomor : {{$detail->draftcode}}</h4>
    <hr>
    <table style="width: 100%">
        <tr>
            <td scope="col" style="width:60%">Gudang : {{$gudang->nama_gudang}}</td>
            <td scope="col" style="width:40%; text-align:right">
                Tanggal : {{$detail->created_at}}
            </td>
          </tr>
        </thead>
    </table>
    <br>
    <p class="center"> DAFTAR BARANG</p>
    <br>

    <table class="table">
        <thead>
          <tr>
            <td style="width:60%"><b>Nama Barang</b></td>
            <td><b>Jumlah</b></td>
            <td><b>Satuan</b></td>
          </tr>
        </thead>
        <tbody>
         @foreach ($list as $li)
            <tr>
                <td>{{$li->barang->uraian}}</td>
                <td>{{$li->jumlah}}</td>
                <td>{{$li->barang->satuan}}</td>
            </tr>
         @endforeach
        </tbody>
      </table>
</body>
</html>
