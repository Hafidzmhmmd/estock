@php
    use App\Http\Helpers\AccessHelpers;
@endphp

<div class="card">
    <div class="header">
        <div class="float-right pr-2">
            @if(AccessHelpers::isPemohon())
            <a class="btn btn-outline-primary btn-round" href="{{ route('pengajuan.pembelian')}}" style="text-decoration: none;">
                Pembelian Baru
            </a>
            @endif
        </div>
        <h2>Riwayat Pengajuan</h2>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table center-aligned-table" id="tblPengajuan">
                <thead>
                <tr>
                    <th width='15%'>Kode Pengajuan</th>
                    <th width='15%'>Tanggal Pengajuan</th>
                    @if(isset($level) && $level > 1)
                        <th width='15%'>Bidang</th>
                    @endif
                    <th>Total Keseluruhan</th>
                    <th width='5%'>Status</th>
                    <th width='5%'></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="modal fade modal-detail" tabindex="-1" role="dialog" aria-labelledby="modal-detail" style="display: none;" aria-hidden="true" id="modalPengajuan">
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
            @if (AccessHelpers::isPPK())
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-danger mb-2 tolakPengajuan">
                        <i class="fa fa-ban"></i> <span>Tolak</span>
                    </button>
                    <button type="button" class="btn btn-outline-success mb-2 setujuiPengajuan">
                        <i class="fa fa-check"></i> <span>Setujui</span>
                    </button>
                </div>
            @elseif (AccessHelpers::isPemohon() || AccessHelpers::isPengelolaBMN())
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-success mb-2 konfirmasiPembelian">
                        <i class="fa fa-check"></i> <span>Konfirmasi Pembelian</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
</div>

@push('js')
<script>
    var dtPengajuan = $('#tblPengajuan').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.pengajuanDataTables') }}",
            @if (isset($slevel) && $slevel)
                data: function(d) {
                    d.level = {{$slevel}};
                }
            @endif
        },
        columns: [
            // columns according to JSON
            {
                data: 'draftcode'
            },
            {
                data: 'tgl_pengajuan'
            },
            @if(isset($level) && $level > 1)
            {
                data: 'bidang'
            },
            @endif
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
                            return `<span class="badge badge-success">Proses Pembelian</span>`;
                        case 'C':
                            return `<span class="badge badge-danger">Ditolak</span>`;
                        case 'F':
                            return `<span class="badge badge-success">Selesai</span>`;
                        default :
                            return `<span class="badge badge-primary">${data}</span>`;
                        }
                    },
                class : 'text-center'
            },
            {
                data: '',
                class : 'text-center'
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
            '<"col-lg-12 col-xl-6 pl-xl-75 p-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>>>' +
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

            $('.tolakPengajuan').hide();
            $('.setujuiPengajuan').hide();
            $('.konfirmasiPembelian').hide();
            if(status == 'A') {
                $('#tglsetujui-text').html(`Tanggal Disetujui : <b><span>` + tglSetujui + `</span></b>`)
                $('.konfirmasiPembelian').show();
            } else if (status == 'C') {
                $('#tglsetujui-text').html(`Tanggal Ditolak : <b><span>` + tglSetujui + `</span></b>`)
            } else if (status == 'F') {
                $('#tglsetujui-text').html(`Tanggal Konfirmasi Pembelian : <b><span>` + tglSetujui + `</span></b>`)
            } else {
                $('.tolakPengajuan').show();
                $('.setujuiPengajuan').show();
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

        @if (AccessHelpers::isPPK())
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
        @endif

        @if (AccessHelpers::isPemohon())
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
        @endif

        @if (AccessHelpers::isPemohon() || AccessHelpers::isPengelolaBMN())
        $('body').on('click', '.konfirmasiPembelian', function (e) {
            e.preventDefault();
            let draftcode = $('#draftcode').text();
            console.log(draftcode)
            $.post('{{route('pengajuan.konfirmasiBeli')}}', {
                'draftcode' : draftcode
            }, function(resp){
                if(resp.status){
                    swal({
                        title: "Success",
                        text: resp.message,
                        type: "success"
                    }, function(){
                        dtPengajuan.ajax.reload();
                    });
                } else {
                    swal('Error', resp.msg, 'info')
                }
            })
        })
        @endif
    });


</script>

@endpush
