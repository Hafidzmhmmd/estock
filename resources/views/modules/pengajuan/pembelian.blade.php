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
            <h5 class="card-title py-2 m-0" >Pengajuan Pembelian Barang {!! $pengajuan ? '- ' : '' !!}<b>{!! $pengajuan ? $pengajuan->draftcode : '' !!}</b>{!! $pengajuan ? '<sup><span class="badge badge-warning">draft</span></sup>' : '' !!}
            </h5>
            <hr>
            <div class="text-right">
                Total Keseluruhan : <b>Rp. <span id="totalAll">{{ $pengajuan ? number_format($pengajuan->total_keseluruhan, 0, '.', '.') : 0 }}</span></b>
            </div>
        </div>
    </div>
    <form method="post" class="invoice-repeater" id="form_ajukan_barang">
        <div class="listholder d-flex flex-column-reverse" data-repeater-list="invoice">
            @if($pengajuan)
            @foreach($pengajuan_detail as $pd)
            <div class="card listItem" data-repeater-item>
                <div class="card-header bg-secondary text-white">
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-light float-right ml-2" data-repeater-delete title="Hapus"><span class="sr-only">Hapus</span><i class="fa fa-close"></i></button>
                        <button type="button" class="btn btn-outline-light float-right editbarang" title="Hapus"><span class="sr-only">Edit</span><i class="fa fa-pencil"></i></button>
                    </div>
                    <h6 class="m-0 py-2 text-uppercase itemName">{{$pd->nama_barang}}</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="hidden" class="idBarang" value="{{$pd->id_barang}}">
                            <p class="card-text m-2"><b>Sub Sub Kelmpok</b> : <span class="subkel">{{$pd->subkel}}</span></p>
                            <p class="card-text m-2"><b>Harga Maksimum</b> : Rp <span class="harga">{{$pd->harga_maksimum}}</span> / <span class="satuan">{{$pd->satuan}}</span></p>
                        </div>
                        <div class="col-md-5 mb-2">
                            <div class="input-group input-group-sm mb-2">
                                <div class="input-group-prepend">
                                    <span class="input-group-text">Rp.</span>
                                </div>
                                <input type="text" class="form-control form-control-sm hargabarang numberdelimiter" aria-describedby="hargabarang" value="{{number_format($pd->harga_satuan, 0, '.', '.')}}" placeholder="Masukan Harga Barang Per Satuan" />
                            </div>
                            <div class="input-group input-group-sm">
                                <input type="text" class="form-control form-control-sm jumlahbarang" aria-describedby="jumlahbarang" value="{{$pd->jumlah_barang}}" placeholder="Masukan Jumlah Barang" oninput="hitungTotalharga(this)" />
                                <div class="input-group-append">
                                    <span class="input-group-text satuan satuanvalue">{{$pd->satuan}}</span>
                                </div>
                            </div>
                            <hr>
                            <b>TOTAL : <span class="totalharga">Rp. {{number_format($pd->total_harga, 0, '.', '.')}}</span></b>
                        </div>
                    </div>

                </div>
            </div>
            @endforeach
            @else
            <div class="card listItem" data-repeater-item style="display: none">
                <div class="card-header bg-secondary text-white">
                    <div class="float-right">
                        <button type="button" class="btn btn-outline-light float-right ml-2" data-repeater-delete title="Hapus"><span class="sr-only">Hapus</span><i class="fa fa-close"></i></button>
                        <button type="button" class="btn btn-outline-light float-right editbarang" title="Hapus"><span class="sr-only">Edit</span><i class="fa fa-pencil"></i></button>
                    </div>
                    <h6 class="m-0 py-2 text-uppercase itemName"></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-2">
                            <input type="hidden" class="idBarang" value="">
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
                                    <span class="input-group-text satuan satuanvalue">Box</span>
                                </div>
                            </div>
                            <hr>
                            <b>TOTAL : <span class="totalharga"></span></b>
                        </div>
                    </div>

                </div>
            </div>
            @endif
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
    const draftcode = `{{@$pengajuan->draftcode}}`
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
                Swal.fire({
                    title: "Apakah yakin?",
                    text: "Anda akan menghapus barang dari list!",
                    type: "warning",
                    showCancelButton: true,
                    confirmButtonColor: "#dc3545",
                    confirmButtonText: "Ya, Hapus",
                    cancelButtonText: "Batal"
                }).then((result) => {
                    if (result.isConfirmed) {
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
        console.log(selectedItem);
        let len = $('.listItem[data-repeater-item]').length
        if(len === 1 && $('.listItem[data-repeater-item]:first-child').is(":hidden")){
            $('.listItem[data-repeater-item]').remove();
            $("div.nextadd").show()
            $("div.firstadd").hide()
        }
        $('[data-repeater-create]').click()
    }

    function insertData(elm){
        elm.find('.idBarang').val(selectedItem.id)
        elm.find('.itemName').html(selectedItem.uraian)
        elm.find('.subkel').html(selectedItem.subsubkelompok)
        elm.find('.harga').html(selectedItem.harga_maksimum)
        elm.find('.satuan').html(selectedItem.satuan)
        elm.find('.hargabarang').val('')
        elm.find('.jumlahbarang').val('')
        elm.find('.penyediabarang').val('')
        elm.find('.totalharga').html('')

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

    $('.savedraft').on('click', function() {
        let frmData = getData();
        if (frmData) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                url: '{{ ENV('APP_URL')}}/pengajuan/simpandraft',
                method: 'POST',
                data: frmData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                success: function(resp) {
                    if (resp.status == true) {
                        Swal.fire({
                            title: 'Success',
                            text:  resp.message,
                            icon: "success",
                            timer: 1000
                        }).then(function() {
                            window.location.href = "{{env('APP_URL')}}/pengajuan/draft/" + resp.draftcode;
                        })
                    } else {
                        Swal.fire({
                            title: "Error",
                            text:  resp.message,
                            icon: "error"
                        });
                    }
                }
            });
        }
    });

    function ajukanBarang() {
        let frmData = getData();
        if(frmData){
            Swal.fire({
                title: "Ajukan Pembelian",
                text: "Pastikan barang sudah sesuai",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                confirmButtonText: "Ya, Ajukan",
                cancelButtonText: "Batal"
            }).then( function (result) {
                if (result.isConfirmed) {
                    frmData.append('ajukan', 1)
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{ ENV('APP_URL')}}/pengajuan/simpandraft',
                        method: 'POST',
                        data: frmData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(resp) {
                            if (resp.status == true) {
                                Swal.fire({
                                    title: 'Success',
                                    text:  resp.message,
                                    icon: "success",
                                    timer: 1000
                                }).then(function() {
                                    window.location.href = "{{env('APP_URL')}}/pengajuan/daftarpembelian/";
                                })
                            } else {
                                Swal.fire({
                                    title: "Error",
                                    text:  resp.message,
                                    icon: "error"
                                });
                            }
                        }
                    });
                }
            });

        } else {
            Swal.fire({
                title: 'Belum disimpan',
                text:  'Klik simpan draft terlebih dahulu',
                icon: "warning",
            })
        }
    }

    function getData(){
        const frmData = new FormData();
        let dataToSend = [];
        let isValid = true;

        let totalKeseluruhan = $('#totalAll').html().replaceAll('.', '');

        $('.listItem').each(function() {
            let itemName = $(this).find('.itemName').text(),
                idBarang = $(this).find('.idBarang').val(),
                subkel = $(this).find('.subkel').text(),
                hargaMaks = $(this).find('.harga').text(),
                satuan = $(this).find('.satuanvalue').text(),
                hargaBarang = $(this).find('.hargabarang').val().replaceAll('.',''),
                jumlahBarang = $(this).find('.jumlahbarang').val(),
                totalHarga = $(this).find('.totalharga').text().replace('Rp.', '').replaceAll('.','')

            if (hargaBarang === '' || jumlahBarang === '' ) {
                $(this).find('.hargabarang, .jumlahbarang, .penyediabarang').css('border', '1px solid red');
                isValid = false;
            } else {
                $(this).find('.hargabarang, .jumlahbarang').css('border', '1px solid #ced4da');

                var itemData = {
                    namaBarang: itemName,
                    idBarang: idBarang,
                    subkel: subkel,
                    hargaMaks: hargaMaks,
                    satuan: satuan,
                    hargaBarang: hargaBarang,
                    jumlahBarang: jumlahBarang,
                    totalHarga: totalHarga,
                };

                dataToSend.push(itemData);
            }
        });
        frmData.append('draftcode', draftcode)
        frmData.append('total_keseluruhan', totalKeseluruhan)
        frmData.append('detail', JSON.stringify(dataToSend))

        if(isValid && dataToSend.length > 0) {
            console.log(frmData)
            return frmData
        } else {
            if (!isValid) {
                Swal.fire({
                    title: 'Data Tidak Valid',
                    text:  'Pastikan semua input terisi dengan benar',
                    icon: "error",
                })
            } else if (dataToSend.length === 0) {
                Swal.fire({
                    title: 'Belum ada barang',
                    text:  'Tambah barang terlebih dahulu',
                    icon: "warning",
                })
            }
            return false
        }
    }


</script>
@endpush
