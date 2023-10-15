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
                <div class="row">
                    <div class="col-md-6">
                        <div>
                            <p>Pemohon : <b><span id="pemohon"></span></b></p>
                            <p>Bidang : <b><span id="bidang"></span></b></p>
                            <p>Tanggal Pengajuan : <b><span id="tgl-pengajuan"></span></b></p>
                            <p id="tglsetujui-text"></p>
                            <p>Total Keseluruhan : <b><span id="total-keseluruhan"></span></b></p>
                        </div>
                    </div>
                    <div class="col-md-6" id="field-penyedia" data-req='false'>
                        <div class="form-group">
                            <label>Penyedia Barang : </label>
                            <input class="form-control form-control-sm" id="nama_penyedia" type="text">
                        </div>
                        <label>Faktur Pembelian : </label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <button class="btn btn-outline-secondary pdfviewer" type="button" data-path=''><i class="fa fa-eye"></i></button>
                            </div>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="faktur_pembeilian">
                                <label class="custom-file-label" for="faktur_pembeilian">Choose file</label>
                            </div>
                        </div>
                    </div>
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
                            </tr>
                            </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger mb-2 tolakPengajuan" data-draftcode="">
                    <i class="fa fa-ban"></i> <span>Tolak</span>
                </button>
                <button type="button" class="btn btn-outline-success mb-2 setujuiPengajuan" data-draftcode="">
                    <i class="fa fa-check"></i> <span>Lanjutkan</span>
                </button>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    var dtPengajuan = $('#tblPengajuan')
    .on('preXhr.dt', function ( e, settings, data ) {
            ajaxLoader();
        })
    .DataTable({
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
        fnDrawCallback: function() {
            closeAjaxLoader();
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
                        render: function(data, type, full, meta) {
                        switch (data) {
                        case 'D':
                            return `<span class="badge badge-default">${full.flow_name}</span>`;
                        case 'P':
                            return `<span class="badge badge-warning">${full.flow_name}</span>`;
                        case 'A':
                            return `<span class="badge badge-success">${full.flow_name}</span>`;
                        case 'C':
                            return `<span class="badge badge-danger">${full.flow_name}</span>`;
                        case 'F':
                            return `<span class="badge badge-primary">${full.flow_name}</span>`;
                        default :
                            return `<span class="badge badge-default">${full.flow_name}</span>`;
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
                        let btnclass = full.has_action ? 'btn-danger' : 'btn-info'
                        return `
                            <button class="btn ${btnclass} btn-sm infoModal" data-toggle="modal" data-target=".modal-detail"><i class="icon-info"></i></button>
                        `;
                    }
                }
            }
        ],
        createdRow : function (row, data, dataIndex){
            if(data.has_action){
                $(row).addClass('xl-blue')
            }
        },
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
            closeAjaxLoader();
        }
    });

    function flow(lanjut, dc){
        const url = lanjut ? '{{env('APP_URL')}}/pengajuan/setujuipengajuan/' : '{{env('APP_URL')}}/pengajuan/tolakpengajuan/'
        const titel = lanjut ? 'Setujui dan Lanjutkan' : 'Tolak Pengajuan'
        const text = lanjut ? 'Anda akan menyetujui pengajuan' : 'Anda Menolak Pengajuan'
        const type = lanjut ? 'info' : 'warning'
        let formData = new FormData();
        formData.append('draftcode', dc);
        let inputPenyedia = $('#field-penyedia').attr('data-req') == 'true';

        if(lanjut && inputPenyedia){
            let np = $('#nama_penyedia').val()
            if(!np){
                swal('Warning', 'Masukan Nama Penyedia', 'warning')
                return false
            } else {
                formData.append('nama_penyedia', np);
                if ($('#faktur_pembeilian').get(0).files.length !== 0){
                    formData.append('faktur', $('#faktur_pembeilian')[0].files[0]);
                } else {
                    swal('Warning', 'Mohon upload faktur pembelian', 'warning')
                    return false
                }
            }
        }
        swal({
            title: titel,
            text: text,
            type: type,
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
                        url: url+dc,
                        method: 'POST',
                        data: formData,
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
                            } else{
                                swal('Error', resp.message, 'info')
                            }
                        }
                    });
                }
            }
        );
    }

    $(document).ready(function() {

        //detail pengajuan
        var dtPengajuanDetail;
        $('body').on('click', '.infoModal', function (e) {
            e.preventDefault();
            const data = dtPengajuan.row($(this).closest('tr')).data()
            let draftcode = data.draftcode;
            let tglPengajuan = data.tgl_pengajuan;
            let totalKeseluruhan = data.total_keseluruhan;
            let status =  data.status;
            let tglSetujui = data.tgl_disetujui;
            let has_action = data.has_action;

            $('#pemohon').html(data.info.pemohon.name)
            $('#bidang').html(data.info.bidang.nama_bidang)

            $('.tolakPengajuan').attr('data-draftcode', '').hide()
            $('.setujuiPengajuan').attr('data-draftcode', '').hide()

            $('#field-penyedia input[type="file"]').siblings('label').html('upload faktur pembelian')
            $('#field-penyedia input[type="file"]').val(null).prop('disabled', false);
            $('#field-penyedia input[type="text"]').val('').prop('disabled', false);
            $('#field-penyedia .pdfviewer').attr('data-path', '')
            $('#field-penyedia').show().attr('data-req', 'false')
            $('#field-penyedia').hide()

            if(has_action){
                if(has_action.includes('acc')){
                    $('.setujuiPengajuan').attr('data-draftcode', draftcode).show()
                }

                if(has_action.includes('decline')){
                    $('.tolakPengajuan').attr('data-draftcode', draftcode).show()
                }

                if(has_action.includes('input_penyedia')){
                    $('#field-penyedia').show().attr('data-req', 'true')
                }
            }


            if(data.nama_penyedia){
                $('#field-penyedia').show()
                $('#field-penyedia input[type="file"]').siblings('label').html('faktur pembelian')
                $('#field-penyedia input[type="file"]').prop('disabled', true);
                $('#field-penyedia input[type="text"]').val(data.nama_penyedia).prop('disabled', true);
                $('#field-penyedia .pdfviewer').attr('data-path', data.faktur)
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

        $('button.setujuiPengajuan').click(function(){
            let dc = $(this).attr('data-draftcode')
            flow(true, dc)
        })

        $('button.tolakPengajuan').click(function(){
            let dc = $(this).attr('data-draftcode')
            flow(false, dc)
        })

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
    });

    $('#field-penyedia .pdfviewer').click(function(){
        let path = $(this).attr('data-path');
        $.fancybox.open({
            src  :  '{{env('APP_URL')}}/getfile/'+path,
            type : 'iframe',
            opts : {
            afterShow : function( instance, current ) {

                }
            }
        });
    })
</script>

@endpush
