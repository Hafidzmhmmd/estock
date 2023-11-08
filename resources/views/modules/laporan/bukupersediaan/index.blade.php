@extends('_layouts.admin')

@section('content')

<div class="card">
    <div class="card-header bg-white">
        <div class="float-right">
            <button type="button" class="btn btn-outline-primary mb-2" data-toggle="modal" data-target=".modal-barang"><i class="fa fa-plus-circle"></i> Buat</button>
        </div>
        <h5 class="card-title py-2 m-0">Buku Persediaan<b></b>
        </h5>
    </div>
</div>

<div class="card p-4">
    <table class="table table-striped" id="tblLaporan">
        <thead>
          <tr>
            <th scope="col">Tanggal Dibuat</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Periode</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
</div>
@include('modules.pengajuan.partials.katalog', [
    "modal_name" => "modal-barang",
    "table_name" => "tblbarang",
    "rowclick" => "addCart(this)",
    "subsubkelompok" => $subsubkelompok,
    "kelompok_barang" => $kelompok_barang,
    "subkelompok" => $subkelompok,
])

@endsection
