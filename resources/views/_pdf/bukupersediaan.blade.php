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

    .table tbody tr td{
        vertical-align: top;
    }
</style>
<body>
    <h3 class="center">RINCIAN BUKU PERSEDIAAN</h3>
    <p class="center">PERIODE {{$dstart}} S/D {{$dend}}</p>
    <br>
    <table style="width: 100%">
        @php
            $identifier = (int)$barang->gol_id.'.'.
            "$barang->bid_id.$barang->kel_id.$barang->subkel_id.$barang->sub_subkel_id.$barang->kode";
        @endphp
        <tr>
            <td scope="col" style="width:12%">KODE BARANG</td>
            <td scope="col" style="width:1%;">:</td>
            <td scope="col" style="width:80%;">{{$identifier}}</td>
        </tr>
        <tr>
            <td scope="col" style="width:12%">NAMA BARANG</td>
            <td scope="col" style="width:1%;">:</td>
            <td scope="col" style="width:80%;">{{$barang->uraian}}</td>
        </tr>
        <tr>
            <td scope="col" style="width:12%">SATUAN</td>
            <td scope="col" style="width:1%;">:</td>
            <td scope="col" style="width:80%;">{{$barang->satuan}}</td>
        </tr>
    </table>
    <table class="table" style="font-size:8pt">
        <thead>
          <tr>
            <th rowspan="2" style="width:15%">Tanggal</th>
            <th rowspan="2" style="width:25%">Dokumen</th>
            <th colspan="3">Masuk</th>
            <th colspan="3">Keluar</th>
            <th colspan="3">Saldo Persediaan</th>
          </tr>
          <tr>
            <td>Unit</td>
            <td>Harga</td>
            <td>Jumlah</td>
            <td>Unit</td>
            <td>Harga</td>
            <td>Jumlah</td>
            <td>Unit</td>
            <td>Harga</td>
            <td>Jumlah</td>
          </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td>Saldo Awal {{$dstart}} </td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>0</td>
                <td>
                    @if($saldo_awal != null)
                        @foreach ($saldo_awal as $sa)
                            {{$sa->stock ? number_format($sa->stock, 0, ".", ",") : 0}}<br>
                        @endforeach
                    @else
                        0
                    @endif

                </td>
                <td>
                    @if($saldo_awal != null)
                        @foreach ($saldo_awal as $sa)
                            {{number_format($sa->harga_satuan, 0, ".", ",")}}<br>
                        @endforeach
                    @else
                        0
                    @endif
                </td>
                <td>
                    @if($saldo_awal != null)
                    @foreach ($saldo_awal as $sa)
                        {{number_format(intval($sa->stock) * intval($sa->harga_satuan), 0, ".", ",")}}<br>
                    @endforeach
                    @else
                        0
                    @endif
                </td>
            </tr>
            @php
                use App\Http\Helpers\StockHelpers;
                $begin = DateTime::createFromFormat('d/m/Y', $dstart);
                $end = DateTime::createFromFormat('d/m/Y', $dend);

                $interval = DateInterval::createFromDateString('1 day');
                $period = new DatePeriod($begin, $interval, $end);
            @endphp
            @foreach ( $period as $dt )
                @php
                    // find keluar dan masuk
                    $mDay = [];
                    $kDay = [];
                    $doc = [];

                    $dateString = $dt->format('d/m/Y');
                    $draw = false;
                    $dmString = '';
                    foreach ($record_masuk as $m) {
                        $dm = DateTime::createFromFormat('Y-m-d H:i:s', $m->tgl_disetujui);
                        $dmString = $dm->format('d/m/Y');
                        if($dateString == $dmString){
                            $draw = true;
                            $mDay[] = $m;
                            $doc[] =  $m->draftcode;
                        }
                    }
                    foreach ($record_keluar as $k) {
                        $km = DateTime::createFromFormat('Y-m-d H:i:s', $k->created_at);
                        $kmString = $km->format('d/m/Y');
                        if($dateString == $kmString){
                            $draw = true;
                            $kDay[] = $k;
                            $doc[] =  $k->draftcode;
                        }
                    }
                @endphp
                @if ($draw)
                    @php
                        $stockDay = StockHelpers::getStockOnDate($dt, $barang->id);
                    @endphp
                    <tr>
                        <td style="text-align: center">{{$dateString}}</td>
                        <td>
                            @foreach ($doc as $d)
                                {{$d}}<br>
                            @endforeach
                        </td>
                        {{-- masuk --}}
                        @if(count($mDay))
                            <td>
                                @foreach ($mDay as $mm)
                                    {{$mm->jumlah_barang ? number_format($mm->jumlah_barang, 0, ".", ",") : 0}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($mDay as $mm)
                                    {{$mm->harga_satuan ? number_format($mm->harga_satuan, 0, ".", ",") : 0}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($mDay as $mm)
                                    {{$mm->jumlah_barang * $mm->harga_satuan > 0 ? number_format($mm->jumlah_barang * $mm->harga_satuan, 0, ".", ",") : 0}}<br>
                                @endforeach
                            </td>
                        @else
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        @endif

                        {{-- keluar --}}
                        @if(count($kDay))
                            <td>
                                @foreach ($kDay as $kk)
                                    {{$kk->ambil ? number_format($kk->ambil, 0, ".", ",") : 0}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($kDay as $kk)
                                    {{$kk->harga_satuan ? number_format($kk->harga_satuan, 0, ".", ",") : 0}}<br>
                                @endforeach
                            </td>
                            <td>
                                @foreach ($kDay as $kk)
                                    {{$kk->ambil * $kk->harga_satuan > 0 ? number_format($kk->ambil * $kk->harga_satuan, 0, ".", ",") : 0}}<br>
                                @endforeach
                            </td>
                        @else
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                        @endif
                        {{-- saldo --}}
                        <td>
                            @if($stockDay != null)
                                @foreach ($stockDay as $sa)
                                    {{$sa->stock ? number_format($sa->stock, 0, ".", ",") : 0}}<br>
                                @endforeach
                            @else
                                0
                            @endif

                        </td>
                        <td>
                            @if($stockDay != null)
                                @foreach ($stockDay as $sa)
                                    {{number_format($sa->harga_satuan, 0, ".", ",")}}<br>
                                @endforeach
                            @else
                                0
                            @endif
                        </td>
                        <td>
                            @if($stockDay != null)
                            @foreach ($stockDay as $sa)
                                {{number_format(intval($sa->stock) * intval($sa->harga_satuan), 0, ".", ",")}}<br>
                            @endforeach
                            @else
                                0
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        </tbody>
      </table>
</body>
</html>
