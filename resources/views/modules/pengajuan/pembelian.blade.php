@extends('_layouts.admin')

@section('content') 
    <div class="row clearfix">
        <div class="col-lg-12 col-md-12 col-sm-12">
            <div class="card">
                <div class="header">
                    <h2>Pembelian Baru</h2>
                    {{-- <ul class="header-dropdown dropdown dropdown-animated scale-left"> 
                        <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                        <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li> 
                    </ul> --}}
                    <ul class="header-dropdown dropdown dropdown-animated scale-left">
                        <button type="button" class="btn btn-success mb-2" onclick="ajukanBarang()">
                            <i class="fa fa-send"></i> <span>Ajukan</span>
                        </button> 
                    </ul>
                </div>
                <div class="card-body">
                    <form method="post" class="invoice-repeater" id="form_ajukan_barang">
                        <div data-repeater-list="invoice">
                            <div data-repeater-item class="listItem">
                                <div class="row d-flex align-items-end">
                                    <div class="col-md-4 col-12">
                                        <div class="form-group">
                                            <label for="namabarang">Nama Barang</label>
                                            <input type="text" class="form-control namabarang" id="namabarang" aria-describedby="namabarang" placeholder="Nama barang" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="itemcost">Harga Satuan</label>
                                            <input type="number" class="form-control hargabarang" id="hargabarang" aria-describedby="hargabarang" placeholder="100000" oninput="hitungTotalharga(this)" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="jumlahbarang">Jumlah Barang</label>
                                            <input type="number" class="form-control jumlahbarang" id="jumlahbarang" aria-describedby="jumlahbarang" placeholder="1" oninput="hitungTotalharga(this)" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="totalharga">Total Harga</label>
                                            <input type="text" readonly class="form-control-plaintext totalharga" id="totalharga" value="0" />
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12 mb-50">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-danger mb-2" data-repeater-delete title="Hapus"><span class="sr-only">Hapus</span><i class="fa fa-trash-o"></i></button>
                                        </div>
                                    </div>
                                </div>
                                <hr />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12"> 
                                <button type="button" data-repeater-create class="btn btn-primary mb-2">
                                    <i class="fa fa-plus-square"></i> <span>Tambah</span>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<!-- Modal Ajukan Barang -->
<div class="modal fade" id="modalAjukanBarang" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalAjukanBarangLabel">List Barang</h4>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama Barang</th>
                                <th>Harga Satuan</th>
                                <th>Jumlah Barang</th>
                                <th>Total Harga</th>
                            </tr>
                        </thead>
                        <tbody id="dataModal"> 
                        </tbody>
                    </table>
                </div> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="kirimPengajuan()">Kirim</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
            </div>
        </div>
    </div>
</div>

 
@endsection
@push('js_vendor') 
<script> 
    $(function () {
    'use strict'; 
        // form repeater
        $('.invoice-repeater, .repeater-default').repeater({
            show: function () {
                $(this).slideDown(); 
            },
            hide: function (deleteElement) {
                let item =  $(this);
                swal({
                    title: "Apakah yakin?",
                    text: "Anda akan menghapus barang dari list!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Ya, Hapus",
                    cancelButtonText: "Batal"
                }, function (isConfirm) {
                    if (isConfirm) {
                        item.slideUp(deleteElement);
                    }
                });
            }
        });
    });
 
    function hitungTotalharga(e) {
      let listItem = e.closest(".listItem");
      let hargaSatuan = parseFloat(listItem.querySelector(".hargabarang").value);
      let jumlahBarang = parseInt(listItem.querySelector(".jumlahbarang").value); 
      let totalHarga = listItem.querySelector(".totalharga");

      let total = hargaSatuan * jumlahBarang;
      totalHarga.value = total; 
    }
 
    function ajukanBarang() {
      let items = document.querySelectorAll(".listItem");
      let dataModal = document.getElementById("dataModal");

      dataModal.innerHTML = "";

      items.forEach(function(item, index) {
        let namaBarang = item.querySelector(".namabarang").value;
        let hargaSatuan = item.querySelector(".hargabarang").value;
        let jumlahBarang = item.querySelector(".jumlahbarang").value;
        let total = item.querySelector(".totalharga").value;

        let dataItem = document.createElement("tr");
        dataItem.innerHTML = "<td>" + (index + 1) + "</td><td> " + namaBarang + "</td><td> " + hargaSatuan + "</td><td>" + jumlahBarang + "</td><td>" + total + "</td>"
        dataModal.appendChild(dataItem);
      }); 
      
      $('#modalAjukanBarang').modal('show');
    }

    function kirimPengajuan() {
        let items = document.querySelectorAll(".listItem");
        let dataToSend = [];

        items.forEach(function(item) {
            let namaBarang = item.querySelector(".namabarang").value;
            var hargaSatuan = parseFloat(item.querySelector(".hargabarang").value);
            var jumlahBarang = parseInt(item.querySelector(".jumlahbarang").value);
            let totalHarga = item.querySelector(".totalharga").value;

            dataToSend.push({
                namabarang: namaBarang,
                hargabarang: hargaSatuan,
                jumlahbarang: jumlahBarang,
                totalharga: totalHarga
            });
        });
        console.log(JSON.stringify(dataToSend));

        swal("Sukses", "Barang telah diajukan", "success");
        
        $('#modalAjukanBarang').modal('hide');

        // $.ajax({
        //     type: "POST",
        //     url: "pengajuanbarang",
        //     data: JSON.stringify(dataToSend),
        //     contentType: "application/json",
        //     success: function(res) { 
        //         console.log(res);
        //     },
        //     error: function(err) {
        //         console.error(err);
        //     }
        // });
    }
 
</script>
@endpush
