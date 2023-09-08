@extends('_layouts.admin')

@section('content')
    <div class="card">
        <div class="card-header bg-white">
            <div class="float-right">
                <button type="button" class="btn btn-outline-primary mb-2 nextadd" data-toggle="modal" data-target=".modal-barang"><i class="fa fa-plus-circle"></i> Tambah</button>
                <button type="button" class="btn btn-outline-secondary mb-2 savedraft"><i class="fa fa-save"></i> Simpan Draft</button>
                <button type="button" class="btn btn-outline-success mb-2" onclick="ajukanBarang()">
                    <i class="fa fa-send"></i> <span>Ajukan</span>
                </button>
            </div>
            <h5 class="card-title py-2 m-0" >Pengajuan Pembelian Barang</h5>
            <hr>
            <div class="text-right">
                Total Keseluruhan : <b>Rp. <span id="totalAll">0</span></b>
            </div>
        </div>
    </div>
    <form method="post" class="invoice-repeater" id="form_ajukan_barang">
        <div class="listholder d-flex flex-column-reverse" data-repeater-list="invoice">
            <div class="card listItem" data-repeater-item style="display: none">
                <div class="card-header bg-secondary text-white">
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-light float-right ml-2" data-repeater-delete title="Hapus"><span class="sr-only">Hapus</span><i class="fa fa-close"></i></button>
                        <button type="button" class="btn btn-outline-light float-right editbarang" title="Hapus"><span class="sr-only">Edit</span><i class="fa fa-pencil"></i></button>
                    </div>
                    <h6 class="m-0 py-2 text-uppercase itemName">Pulpen</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <p class="card-text m-2"><b>Sub Sub Kelmpok</b> : <span class="subkel"></span></p>
                            <p class="card-text m-2"><b>Harga Maksimum</b> : Rp <span class="harga"></span> / <span class="satuan"></span></p>
                        </div>
                        <div class="col-md-5 mb-2">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control form-control-sm hargabarang numberdelimiter" aria-describedby="hargabarang" placeholder="Masukan Harga Barang Per Satuan" />
                            </div>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm jumlahbarang" aria-describedby="jumlahbarang" placeholder="Masukan Jumlah Barang" oninput="hitungTotalharga(this)" />
                                <div class="input-group-append">
                                    <span class="input-group-text satuan">Box</span>
                                </div>
                            </div>
                            <hr>
                            <b>TOTAL : <span class="totalharga"></span></b>
                        </div>
                        <div class="col-md-4 mb-2">
                            <div class="form-group pt-2">
                                <label>Penyedia Barang :</label>
                                <input type="text" class="form-control penyediabarang" placeholder="">
                              </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <button type="button" class="btn btn-block btn-outline-primary"  data-repeater-create hidden></button>
    </form>

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

@include('modules.pengajuan.partials.katalog', [
    "modal_name" => "modal-barang",
    "table_name" => "tblbarang",
    "rowclick" => "addCart(this)",
    "subsubkelompok" => $subsubkelompok,
    "kelompok_barang" => $kelompok_barang,
    "subkelompok" => $subkelompok,
])

@endsection
@push('js')
<script>
    $("#namabarang").select2({
        theme: "bootstrap"
    });
    $(function () {
        // form repeater
        $('.invoice-repeater, .repeater-default').repeater({
            show: function () {
                insertData($(this))
                $(".modal-barang").modal('hide')
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

    let selectedItem = null;
    function addCart(e){
        let row = $(e).closest('tr');
        selectedItem = dt_tblbarang.row(row).data()
        let len = $('.listItem[data-repeater-item]').length
        if(len === 1 && $('.listItem[data-repeater-item]:first-child').is(":hidden")){
            $('.listItem[data-repeater-item]').remove();
            $("div.nextadd").show()
            $("div.firstadd").hide()
        }
        $('[data-repeater-create]').click()
    }

    function insertData(elm){
        elm.find('.itemName').html(selectedItem.uraian)
        elm.find('.subkel').html(selectedItem.subsubkelompok)
        elm.find('.harga').html(selectedItem.harga_maksimum)
        elm.find('.satuan').html(selectedItem.satuan)
    }

    $('#form_ajukan_barang .listholder').on({
    focusout:function(){
        let val = $(this).val()
        if(!isNaN(parseInt(val.replaceAll('.','')))){
            $(this).val(numberWithCommas(val))
        }
    },
    focusin:function(){
        let val = $(this).val()
        $(this).val(val.replaceAll('.',''))
    }
    },'.numberdelimiter');

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    function hitungTotalharga(e){
        let val = parseInt($(e).val());
        let item = $(e).closest('.listItem[data-repeater-item]');
        let harga = parseInt(item.find('input.hargabarang').val().replaceAll('.',''))
        if(!isNaN(val) && !isNaN(harga)){
            item.find(".totalharga").html(`Rp. ${numberWithCommas(harga*val)}`)
            calculateAll()
        } else {
            item.find(".totalharga").html("Tidak dapat diproses, cek inputan anda")
        }
    }

    function calculateAll(){
        let hargas = [];
        $('.listItem[data-repeater-item]').each(function(){
            let thisharga = $(this).find(".totalharga").html();
            console.log("this harga :",thisharga)
            let theInt = thisharga.replace('Rp.', '').replaceAll('.','')
            if(!isNaN(parseInt(theInt))){
                hargas.push(parseInt(theInt))
            }
        })
        let sum = hargas.reduce((accumulator, currentValue) => {
            return accumulator + currentValue
        },0);
        $("#totalAll").html(numberWithCommas(sum));
    }
</script>
@endpush
