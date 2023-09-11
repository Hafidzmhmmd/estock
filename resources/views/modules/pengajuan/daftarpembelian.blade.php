@extends('_layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <a class="btn btn-primary btn-round float-right" href="{{route('pengajuan.pembelian')}}" style="text-decoration: none;">Pembelian Baru</a>
        <h5 class="card-title">Daftar Pembelian</h5> 
        
    </div>
</div>

<div class="card">
    <div class="header">
        <h2>Riwayat Pengajuan</h2>
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
            <table class="table center-aligned-table" id="tblPengajuan">
                <thead>
                <tr>
                    <th width='15%'>Draftcode</th>
                    <th width='15%'>Tanggal Pengajuan</th>
                    <th>Total Keseluruhan</th>
                    <th>Status</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">List Barang <span id="draftcode"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body"> 
                <div><p>Tanggal Pengajuan : <b><span id="tgl-pengajuan"></span></b></p> 
                    <p id="tglsetujui-text"></p>
                    <p>Total Keseluruhan : <b><span id="total-keseluruhan"></span></b></p> 
                </div>
                <hr>
                <div class="table-responsive">
                    <table class="table table-hover center-aligned-table" id="tblPengajuanDetail" style="width:100%">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Subkel</th>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Maksimum</th>
                                <th>Harga Satuan</th>
                                <th>Total Harga</th>
                                <th>Penyedia Barang</th>
                            </tr>
                            </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="display: none">
                <button type="button" class="btn btn-outline-danger mb-2 tolakPengajuan">
                    <i class="fa fa-ban"></i> <span>Tolak</span>
                </button>
                <button type="button" class="btn btn-outline-success mb-2 setujuiPengajuan">
                    <i class="fa fa-check"></i> <span>Setujui</span>
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@push('js')
<script>
    var dtPengajuan = $('#tblPengajuan').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.pengajuanDataTables') }}",
        },
        columns: [
            // columns according to JSON
            {
                data: 'draftcode'
            },
            {
                data: 'tgl_pengajuan'
            },
            {
                data: 'total_keseluruhan',
                render: function(data){
                    return 'Rp. ' + Number(data).toLocaleString('id-ID');
                }
            },
            {
                data: 'status',
                        render: function(data) {
                        switch (data) {
                        case 'D':
                            return `<span class="badge badge-default">Draft</span>`;
                        case 'P':
                            return `<span class="badge badge-warning">Menunggu Persetujuan</span>`; 
                        case 'A':
                            return `<span class="badge badge-success">Disetujui</span>`; 
                        case 'C':
                            return `<span class="badge badge-danger">Ditolak</span>`; 
                        default :
                            return `<span class="badge badge-primary">${data}</span>`;
                        }
                    }
            },
            {
                data: ''
            },
        ],
        columnDefs: [
            {
                // Actions 
                targets: -1,
                title: 'Actions',
                orderable: false,
                render: function(data, type, full, meta) {
                    if (full.status === 'D') {
                        return `
                            <button class="btn btn-warning btn-sm editDraft" data-id="${full.draftcode}"><i class="icon-pencil"></i></button>
                            <button class="btn btn-danger btn-sm hapusDraft" data-id="${full.draftcode}"><i class="icon-trash"></i></button>
                        `;
                    } else {
                        return `
                            <button class="btn btn-info btn-sm infoModal" data-id="${full.draftcode}" data-status="${full.status}" data-tgl="${full.tgl_pengajuan}" data-tgl-setujui="${full.tgl_disetujui}" data-total="${full.total_keseluruhan}" data-toggle="modal" data-target=".modal-detail"><i class="icon-info"></i></button> 
                        `;
                    }
                }
            }
        ],
        order: [
            [1, 'asc']
        ],
        dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
            '<"col-lg-12 col-xl-6" l>' +
            '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>>>' +
            '>t' +
            '<"d-flex justify-content-between mx-2 row mb-1"' +
            '<"col-sm-12 col-md-6"i>' +
            '<"col-sm-12 col-md-6"p>' +
            '>',
        language: {
            sLengthMenu: 'Show _MENU_',
            search: '',
            searchPlaceholder: 'Search..',
            paginate: {
                // remove previous & next text from pagination
                previous: '&nbsp;',
                next: '&nbsp;'
            }
        },
        initComplete: function() {

        }
    });
 
    $(document).ready(function() {

        //detail pengajuan
        var dtPengajuanDetail; 
        $('body').on('click', '.infoModal', function (e) {
            e.preventDefault();
            let draftcode = $(this).data('id');
            let tglPengajuan = $(this).data('tgl');
            let totalKeseluruhan = $(this).data('total'); 
            let status =  $(this).data('status'); 
            let tglSetujui =  $(this).data('tgl-setujui'); 
            if(status == 'P') {
                $('.modal-footer').show();
            } else {
                $('.modal-footer').hide();
            }

            if(status == 'A') {
                $('#tglsetujui-text').html(`Tanggal Disetujui : <b><span>` + tglSetujui + `</span></b>`)
            } else if (status == 'C') {
                $('#tglsetujui-text').html(`Tanggal Ditolak : <b><span>` + tglSetujui + `</span></b>`) 
            }

            $('#draftcode').html(draftcode);
            $('#tgl-pengajuan').html(tglPengajuan);
            $('#total-keseluruhan').html('Rp. ' + Number(totalKeseluruhan).toLocaleString('id-ID'));

           if (dtPengajuanDetail) {
               dtPengajuanDetail.destroy();
            } 
           dtPengajuanDetail = $('#tblPengajuanDetail').DataTable({
                processing: true,
                serverSide: true,
                "ajax": {
                    "url": "{{ route('data.pengajuandetailDataTables') }}",
                    data: function (d) {
                        d.draftcode = draftcode
                    }
                },
                columns: [
                    // columns according to JSON
                    { 
                        render: function(item, data, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'subkel'
                    },
                    {
                        data: 'nama_barang'
                    },
                    {   
                        data: null,
                        render: function (data, type, row) {
                            return data.jumlah_barang + ' ' + data.satuan;
                        }
                    },
                    {
                        data: 'harga_maksimum',
                        render: function(data){
                            return 'Rp. ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'harga_satuan',
                        render: function(data){
                            return 'Rp. ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'total_harga',
                        render: function(data){
                            return 'Rp. ' + Number(data).toLocaleString('id-ID');
                        }
                    },
                    {
                        data: 'penyedia_barang'
                        
                    },  
                ], 
                order: [
                    [0, 'asc']
                ],
                dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                    '<"col-lg-12 col-xl-6" l>' +
                    '<"col-lg-12 col-xl-6 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>>>' +
                    '>t' +
                    '<"d-flex justify-content-between mx-2 row mb-1"' +
                    '<"col-sm-12 col-md-6"i>' +
                    '<"col-sm-12 col-md-6"p>' +
                    '>',
                language: {
                    sLengthMenu: 'Show _MENU_',
                    search: '',
                    searchPlaceholder: 'Search..',
                    paginate: {
                        // remove previous & next text from pagination
                        previous: '&nbsp;',
                        next: '&nbsp;'
                    }
                },
                initComplete: function() {

                }
            });
        });

        //setujui pengajuan 
        $('body').on('click', '.setujuiPengajuan', function (e) {
            e.preventDefault();
            let draftcode = $('#draftcode').text();
            swal({
                title: "Setujui Pengajuan",
                text: "Anda akan menyetujui pengajuan",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#28a745",
                confirmButtonText: "Ya, Setujui",
                cancelButtonText: "Batal"
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url: '{{env('APP_URL')}}/pengajuan/setujuipengajuan/'+draftcode,
                            method: 'POST',
                            data: {'draftcode':draftcode},
                            contentType: false,
                            processData: false,
                            dataType: "JSON",
                            success: function(resp) { 
                                if(resp.status == true){
                                    $('.modal-detail').modal('hide');
                                    $('.modal-footer').hide();
                                    swal({
                                        title: "Success",
                                        text: resp.message,
                                        type: "success"
                                    }, function(){
                                        dtPengajuan.ajax.reload();
                                    });   
                                }else{
                                    swal('Error', resp.message, 'info')
                                }
                            }
                        }); 
                    }
                }); 
            }); 

        //tolak pengajuan 
        $('body').on('click', '.tolakPengajuan', function (e) {
            e.preventDefault();
            let draftcode = $('#draftcode').text();
            swal({
                title: "Tolak Pengajuan",
                text: "Anda akan menolak pengajuan",
                type: "info",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Ya, Tolak",
                cancelButtonText: "Batal"
                }, function (isConfirm) {
                    if (isConfirm) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            url: '{{env('APP_URL')}}/pengajuan/tolakpengajuan/'+draftcode,
                            method: 'POST',
                            data: {'draftcode':draftcode},
                            contentType: false,
                            processData: false,
                            dataType: "JSON",
                            success: function(resp) { 
                                if(resp.status == true){
                                    $('.modal-detail').modal('hide');
                                    $('.modal-footer').hide();
                                    swal({
                                        title: "Success",
                                        text: resp.message,
                                        type: "success"
                                    }, function(){
                                        dtPengajuan.ajax.reload();
                                    });   
                                }else{
                                    swal('Error', resp.message, 'info')
                                }
                            }
                        }); 
                    }
                });   
            }); 

        //edit draft
        $('body').on('click', '.editDraft', function (e) {
           e.preventDefault();
           let draftcode = $(this).data('id');  
           window.location.href = "{{env('APP_URL')}}/pengajuan/draft/" + draftcode;
        });

        //hapus draft
        $('body').on('click', '.hapusDraft', function (e) {
            e.preventDefault();
            let draftcode = $(this).data('id'); 
            swal({
                title: "Apakah yakin?",
                text: "Anda akan menghapus draft pengajuan",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#dc3545",
                confirmButtonText: "Ya, Hapus",
                cancelButtonText: "Batal"
            }, function (isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        url: '{{env('APP_URL')}}/pengajuan/hapusdraft/'+draftcode,
                        method: 'DELETE',
                        data: {'draftcode':draftcode},
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        success: function(resp) { 
                            if(resp.status == true){
                                swal({
                                    title: "Success",
                                    text: resp.message,
                                    type: "success"
                                }, function(){
                                    dtPengajuan.ajax.reload();
                                });   
                            }else{
                                swal('Error', resp.message, 'info')
                            }
                        }
                    }); 
                }
            }); 
        });

    });

   
</script>

@endpush
