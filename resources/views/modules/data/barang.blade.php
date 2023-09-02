@extends('_layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-round float-right">Tambah Data</button>
        <h5 class="card-title">Pengaturan Data Barang</h5>
        <hr>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="sclSubKelompok">Sub Kelompok</label>
                    <select class="form-control" id="sclSubKelompok">
                        <option value="" selected="true" disabled="disabled">[Pilih Kelompok Barang]</option>
                        @foreach ($subkelompok as $subkel)
                            <option value="{{$subkel->subkel_id}}">{{$subkel->subkelompok}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="slcKelompok">Kelompok</label>
                    <select class="form-control" id="slcKelompok">
                        <option value="" selected="true" disabled="disabled">[Pilih Kelompok Barang]</option>
                        @foreach ($kelompok_barang as $kel)
                            <option value="{{$kel->kel_id}}">{{$kel->kelompok}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="slcBidang">Bidang</label>
                    <select class="form-control" id="slcBidang">
                        <option value="" selected="true" disabled="disabled">[Pilih Bidang Barang]</option>
                        @foreach ($bidang_barang as $bid)
                            <option value="{{$bid->bid_id}}">{{$bid->bidang}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="header">
        <h2>Data Barang</h2>
        <ul class="header-dropdown dropdown dropdown-animated scale-left">
            <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"></a>
                <ul class="dropdown-menu">
                    <li><a href="javascript:void(0);">Action</a></li>
                    <li><a href="javascript:void(0);">Another Action</a></li>
                    <li><a href="javascript:void(0);">Something else</a></li>
                </ul>
            </li>
        </ul>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table center-aligned-table">
                <thead>
                <tr>
                    <th>Kode</th>
                    <th>Uraian</th>
                    <th>Satuan</th>
                    <th>Harga Maksimum</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Q01</td>
                    <td>Iphone 7</td>
                    <td>12 Jan 2018</td>
                    <td>Dispatched</td>
                    <td><button class="btn btn-danger btn-sm"><i class="icon-trash"></i></button></td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
