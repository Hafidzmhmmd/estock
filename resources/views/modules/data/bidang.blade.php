@extends('_layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <button type="button" data-toggle="modal" data-target="#modal-add-bidang" class="btn btn-primary btn-round float-right">Tambah Data</button>
        <h5 class="card-title">Pengaturan Data Bidang Barang</h5> 
    </div>
</div>

<div class="card">
    <div class="header">
        <h2>Data Bidang Barang</h2>
        <ul class="header-dropdown dropdown dropdown-animated scale-left">
            <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
            <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li> 
        </ul>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table center-aligned-table" id="tblBidang">
                <thead>
                <tr>
                    <th width='15%'>ID Bidang</th>
                    <th>Golongan</th>
                    <th>Bidang</th> 
                    <th width='15%'></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- modal add bidang --}}
<div class="modal fade" id="modal-add-bidang" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalBidangLabel">Tambah Bidang Barang</h4>
            </div>
            <form id="form_add_bidang" method="POST" action="javascript:void(0)"> 
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row"> 
                        <div class="col-12">
                            <div class="form-group">
                                <label for="gol_id">Golongan</label>
                                <select class="form-control" id="gol_id" name="gol_id" data-parent='' required>
                                    <option value="" selected="true">Semua Golongan Barang</option>
                                    @foreach ($golongan_barang as $gol)
                                    <option
                                        value="{{sprintf('%02d', $gol->gol_id)}}">
                                        {{sprintf('%02d', $gol->gol_id)}} - {{$gol->golongan}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="bid_id">ID Bidang</label>
                                <input type="text" id="bid_id" name="bid_id" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="bidang">Bidang</label>
                                <input type="text" id="bidang" name="bidang" class="form-control" required>
                            </div>
                        </div>
                    </div> 
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>                               
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('js')
<script>
    var dtBidang = $('#tblBidang').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.bidangDataTables') }}"
        },
        columns: [
            // columns according to JSON
            {
                data: 'bid_id'
            },
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.gol_id} - ${row.golongan}`); 
                }
            }, 
            {
                data: 'bidang'
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
                render: function(data, type, row) { 
                        return (`
                            <button class="btn btn-warning btn-sm editData" data-id="` + row.id + `"><i class="icon-pencil"></i></button>
                            <button class="btn btn-danger btn-sm deleteData" data-id="` + row.id + `"><i class="icon-trash"></i></button>
                        `);
                   
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

    // Add bidang
    $('#form_add_bidang').submit(function (e) {
        e.preventDefault();

        let frmData = new FormData($(this)[0]);

        $('#submitButton').attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{route('bidang.store')}}',
            method: 'POST',
            data: frmData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (resp) { 
                $('#submitButton').attr('disabled', false).html('Simpan');
                if (resp.status == true) {
                    Swal.fire('Success', resp.message, 'success');
                    $('#modal-add-bidang').modal('hide');
                    dtBidang.ajax.reload();
                } else {
                    Swal.fire('Error', resp.message, 'error');
                }
            }
        });
    }); 

    // detail bidang 
     $('body').on('click', '.editData', function () {
        let id = $(this).data('id');
        $.get("{{ route('bidang.detail', ['id' => '']) }}/" + id, function(data, status) {
             
            $('#id').val(data.data.id);
            $('#bid_id').val(data.data.bid_id);
            $('#gol_id').val(data.data.gol_id);
            $('#bidang').val(data.data.bidang);
            $('#modalBidangLabel').html('Edit Bidang Barang');
 
            $('#modal-add-bidang').modal('show'); 
        })
    }); 

    // Aksi Delete
    $('body').on('click', '.deleteData', function (e) {
        e.preventDefault();
        let id = $(this).data('id');
            
        Swal.fire({
            title: 'Yakin Hapus ?',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#7367f0',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    url: "{{ route('bidang.delete', ['id' => '']) }}/" + id,
                    method: 'DELETE', 
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(resp) {
                                
                        if (resp.status == true) {
                            Swal.fire('Success', resp.message, 'success')
                            .then(function(){
                                dtBidang.ajax.reload(); 
                            })
                        } else {
                            Swal.fire('Error', resp.message, 'error')
                        }
                    }
                }); 
            }
        })
    });

    $('#modal-add-bidang').on('hidden.bs.modal', function () { 
        $('#id').val('');
        $('.form-control').val('');
        $('#modalBidangLabel').html('Tambah Bidang Barang');
    });
</script>

@endpush