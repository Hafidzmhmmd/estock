@extends('_layouts.admin')

@section('content')


<ul class="nav nav-tabs">
    <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#tkelompok">Kelompok</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tsubkelompok">Sub Kelompok</a></li>
    <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#tsubsubkelompok">Sub Sub Kelompok</a></li>
</ul>
<div class="tab-content">
    <div class="tab-pane show active" id="tkelompok">

        <div class="card">
            <div class="card-body">
                <button type="button" data-toggle="modal" data-target="#modal-add-kelompok" class="btn btn-primary btn-round float-right">Tambah Data</button>
                <h5 class="card-title">Pengaturan Data Kelompok Barang</h5> 
            </div>
        </div>
        <div class="card">
            <div class="header">
                <h2>Data Kelompok Barang</h2>
                <ul class="header-dropdown dropdown dropdown-animated scale-left">
                    <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li> 
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table center-aligned-table" id="tblKelompok">
                        <thead>
                        <tr>
                            <th width='15%'>ID Kelompok</th>
                            <th>Golongan</th>
                            <th>Bidang</th>
                            <th>Kelompok</th> 
                            <th width='15%'></th>
                        </tr>
                        </thead>
                        <tbody>
        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="tsubkelompok">

        <div class="card">
            <div class="card-body">
                <button type="button" data-toggle="modal" data-target="#modal-add-subkelompok" class="btn btn-primary btn-round float-right">Tambah Data</button>
                <h5 class="card-title">Pengaturan Data Sub Kelompok Barang</h5> 
            </div>
        </div>
        <div class="card">
            <div class="header">
                <h2>Data Sub Kelompok Barang</h2>
                <ul class="header-dropdown dropdown dropdown-animated scale-left">
                    <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li> 
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table center-aligned-table" id="tblSubKelompok">
                        <thead>
                        <tr>
                            <th width='15%'>ID Sub Kelompok</th>
                            <th>Kelompok</th>
                            <th>Golongan</th>
                            <th>Bidang</th>
                            <th>Kelompok</th> 
                            <th width='15%'></th>
                        </tr>
                        </thead>
                        <tbody>
        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <div class="tab-pane" id="tsubsubkelompok">
        <div class="card">
            <div class="card-body">
                <button type="button" data-toggle="modal" data-target="#modal-add-subsubkelompok" class="btn btn-primary btn-round float-right">Tambah Data</button>
                <h5 class="card-title">Pengaturan Data Sub Sub Kelompok Barang</h5> 
            </div>
        </div>
        <div class="card">
            <div class="header">
                <h2>Data Sub Sub Kelompok Barang</h2>
                <ul class="header-dropdown dropdown dropdown-animated scale-left">
                    <li> <a href="javascript:void(0);" data-toggle="cardloading" data-loading-effect="pulse"><i class="icon-refresh"></i></a></li>
                    <li><a href="javascript:void(0);" class="full-screen"><i class="icon-size-fullscreen"></i></a></li> 
                </ul>
            </div>
            <div class="body">
                <div class="table-responsive">
                    <table class="table center-aligned-table" id="tblSubSubKelompok">
                        <thead>
                        <tr>
                            <th width='15%'>ID Sub Sub Kelompok</th>
                            <th>Kelompok</th>
                            <th>Sub Kelompok</th>
                            <th>Golongan</th>
                            <th>Bidang</th>
                            <th>Kelompok</th> 
                            <th width='15%'></th>
                        </tr>
                        </thead>
                        <tbody>
        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>



{{-- modal add kelompok --}}
<div class="modal fade" id="modal-add-kelompok" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalKelompokLabel">Tambah Kelompok Barang</h4>
            </div>
            <form id="form_add_kelompok" method="POST" action="javascript:void(0)"> 
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row" id="filteradd">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="gol_id">Golongan</label>
                                <select class="form-control" id="gol_id" name="gol_id" data-parent='' required>
                                    <option value="" selected="true">Semua Golongan Barang</option>
                                    @foreach ($golongan_barang as $gol)
                                    <option
                                        value="{{sprintf('%02d', $gol->gol_id)}}">
                                        {{$gol->golongan}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-6">
                            <div class="form-group">
                                <label for="bid_id">Bidang</label>
                                <select class="form-control" id="bid_id" name="bid_id" data-parent='gol_id' required>
                                    <option value="" selected="true">Semua Bidang Barang</option>
                                    @foreach ($bidang_barang as $bid)
                                    <option
                                        data-parent="{{sprintf('%02d', $bid->gol_id)}}"
                                        value="{{sprintf('%02d', $bid->bid_id)}}">
                                        {{$bid->bidang}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group">
                                <label for="kel_id">ID Kelompok</label>
                                <input type="text" id="kel_id" name="kel_id" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-8">
                            <div class="form-group">
                                <label for="kelompok">Kelompok</label>
                                <input type="text" id="kelompok" name="kelompok" class="form-control" required>
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

{{-- modal add sub kelompok --}}
<div class="modal fade" id="modal-add-subkelompok" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalSubKelompokLabel">Tambah Sub Kelompok Barang</h4>
            </div>
            <form id="form_add_subkelompok" method="POST" action="javascript:void(0)"> 
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row" id="filteradd">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="gol_id">Golongan</label>
                                <select class="form-control" id="gol_id" name="gol_id" data-parent='' required>
                                    <option value="" selected="true">Semua Golongan Barang</option>
                                    @foreach ($golongan_barang as $gol)
                                    <option
                                        value="{{sprintf('%02d', $gol->gol_id)}}">
                                        {{$gol->golongan}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-6">
                            <div class="form-group">
                                <label for="bid_id">Bidang</label>
                                <select class="form-control" id="bid_id" name="bid_id" data-parent='gol_id' required>
                                    <option value="" selected="true">Semua Bidang Barang</option>
                                    @foreach ($bidang_barang as $bid)
                                    <option
                                        data-parent="{{sprintf('%02d', $bid->gol_id)}}"
                                        value="{{sprintf('%02d', $bid->bid_id)}}">
                                        {{$bid->bidang}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="kel_id">Kelompok</label>
                                <select class="form-control" id="kel_id" name="kel_id" data-parent='' required>
                                    <option value="" selected="true">Semua Kelompok Barang</option>
                                    @foreach ($kelompok_barang as $kel)
                                    <option
                                        value="{{sprintf('%02d', $kel->kel_id)}}">
                                        {{$kel->kelompok}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-6">
                            <div class="form-group">
                                <label for="subkel_id">ID Sub Kelompok</label>
                                <input type="text" id="subkel_id" name="subkel_id" class="form-control" required>
                            </div>
                        </div> 
                    </div> 
                    <div class="row"> 
                        <div class="col-12">
                            <div class="form-group">
                                <label for="subkelompok">Sub Kelompok</label>
                                <input type="text" id="subkelompok" name="subkelompok" class="form-control" required>
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

{{-- modal add sub sub kelompok --}}
<div class="modal fade" id="modal-add-subsubkelompok" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalSubSubKelompokLabel">Tambah Sub Kelompok Barang</h4>
            </div>
            <form id="form_add_subsubkelompok" method="POST" action="javascript:void(0)"> 
                <input type="hidden" id="id" name="id">
                <div class="modal-body">
                    <div class="row" id="filteradd">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="gol_id">Golongan</label>
                                <select class="form-control" id="gol_id" name="gol_id" data-parent='' required>
                                    <option value="" selected="true">Semua Golongan Barang</option>
                                    @foreach ($golongan_barang as $gol)
                                    <option
                                        value="{{sprintf('%02d', $gol->gol_id)}}">
                                        {{$gol->golongan}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                        <div class="col-6">
                            <div class="form-group">
                                <label for="bid_id">Bidang</label>
                                <select class="form-control" id="bid_id" name="bid_id" data-parent='gol_id' required>
                                    <option value="" selected="true">Semua Bidang Barang</option>
                                    @foreach ($bidang_barang as $bid)
                                    <option
                                        data-parent="{{sprintf('%02d', $bid->gol_id)}}"
                                        value="{{sprintf('%02d', $bid->bid_id)}}">
                                        {{$bid->bidang}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="kel_id">Kelompok</label>
                                <select class="form-control" id="kel_id" name="kel_id" data-parent='' required>
                                    <option value="" selected="true">Semua Kelompok Barang</option>
                                    @foreach ($kelompok_barang as $kel)
                                    <option
                                        value="{{sprintf('%02d', $kel->kel_id)}}">
                                        {{$kel->kelompok}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="subkel_id">Sub Kelompok</label>
                                <select class="form-control" id="subkel_id" name="subkel_id" data-parent='kel_id' required>
                                    <option value="" selected="true">Semua Sub Kelompok Barang</option>
                                    @foreach ($subkelompok as $subkel)
                                    <option
                                        data-parent="{{sprintf('%02d', $subkel->kel_id)}}"
                                        value="{{sprintf('%02d', $subkel->subkel_id)}}">
                                        {{$subkel->subkelompok}}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div> 
                    <div class="row"> 
                        <div class="col-4">
                            <div class="form-group">
                                <label for="sub_subkel_id">ID Sub Sub Kelompok</label>
                                <input type="text" id="sub_subkel_id" name="sub_subkel_id" class="form-control" required>
                            </div>
                        </div> 
                        <div class="col-8">
                            <div class="form-group">
                                <label for="sub_subkelompok">Sub Sub Kelompok</label>
                                <input type="text" id="sub_subkelompok" name="sub_subkelompok" class="form-control" required>
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

$('#gol_id, #bid_id, #kel_id, #subkel_id').change(function(){
        let id = $(this).attr('id');
        let child = $(`#filteradd select[data-parent='${id}']`);
        let val = $(this).val();
        if(child && val){
            child.find(`option[data-parent!=${val}]`).hide()
            let cc = child.find(`option:selected`).attr('data-parent')
            if(cc != val){
                child.val('')
            }
        } else if(child){
            child.find(`option`).show()
        } 
    }); 

    var dtKelompok = $('#tblKelompok').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.kelompokDataTables') }}"
        },
        columns: [
            // columns according to JSON
            {
                data: 'kel_id'
            },
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.gol_id} - ${row.golongan}`); 
                }
            }, 
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.bid_id} - ${row.bidang}`); 
                }
            },  
            {
                data: 'kelompok'
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

    var dtSubKelompok = $('#tblSubKelompok').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.subkelompokDataTables') }}"
        },
        columns: [
            // columns according to JSON
            {
                data: 'subkel_id'
            },
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.kel_id} - ${row.kelompok}`); 
                }
            }, 
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.gol_id} - ${row.golongan}`); 
                }
            }, 
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.bid_id} - ${row.bidang}`); 
                }
            },  
            {
                data: 'subkelompok'
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
                            <button class="btn btn-warning btn-sm editDataSub" data-id="` + row.id + `"><i class="icon-pencil"></i></button>
                            <button class="btn btn-danger btn-sm deleteDataSub" data-id="` + row.id + `"><i class="icon-trash"></i></button>
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

    var dtSubSubKelompok = $('#tblSubSubKelompok').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.subsubkelompokDataTables') }}"
        },
        columns: [
            // columns according to JSON
            {
                data: 'sub_subkel_id'
            },
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.kel_id} - ${row.kelompok}`); 
                }
            }, 
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.subkel_id} - ${row.subkelompok}`); 
                }
            }, 
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.gol_id} - ${row.golongan}`); 
                }
            }, 
            {
                data: null,
                render: function(data, type, row) { 
                        return (`${row.bid_id} - ${row.bidang}`); 
                }
            },  
            {
                data: 'sub_subkelompok'
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
                            <button class="btn btn-warning btn-sm editDataSubSub" data-id="` + row.id + `"><i class="icon-pencil"></i></button>
                            <button class="btn btn-danger btn-sm deleteDataSubSub" data-id="` + row.id + `"><i class="icon-trash"></i></button>
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

    // Add kelompok
    $('#form_add_kelompok').submit(function (e) {
        e.preventDefault();

        let frmData = new FormData($(this)[0]);

        $('#submitButton').attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{route('kelompok.store')}}',
            method: 'POST',
            data: frmData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (resp) { 
                $('#submitButton').attr('disabled', false).html('Simpan');
                if (resp.status == true) {
                    Swal.fire('Success', resp.message, 'success');
                    $('#modal-add-kelompok').modal('hide');
                    dtKelompok.ajax.reload();
                } else {
                    Swal.fire('Error', resp.message, 'error');
                }
            }
        });
    }); 

     // Add sub kelompok
     $('#form_add_subkelompok').submit(function (e) {
        e.preventDefault();

        let frmData = new FormData($(this)[0]);

        $('#submitButton').attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{route('subkelompok.store')}}',
            method: 'POST',
            data: frmData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (resp) { 
                $('#submitButton').attr('disabled', false).html('Simpan');
                if (resp.status == true) {
                    Swal.fire('Success', resp.message, 'success');
                    $('#modal-add-subkelompok').modal('hide');
                    dtSubKelompok.ajax.reload();
                } else {
                    Swal.fire('Error', resp.message, 'error');
                }
            }
        });
    }); 

     // Add sub sub kelompok
     $('#form_add_subsubkelompok').submit(function (e) {
        e.preventDefault();

        let frmData = new FormData($(this)[0]);

        $('#submitButton').attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{route('subsubkelompok.store')}}',
            method: 'POST',
            data: frmData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function (resp) { 
                $('#submitButton').attr('disabled', false).html('Simpan');
                if (resp.status == true) {
                    Swal.fire('Success', resp.message, 'success');
                    $('#modal-add-subsubkelompok').modal('hide');
                    dtSubSubKelompok.ajax.reload();
                } else {
                    Swal.fire('Error', resp.message, 'error');
                }
            }
        });
    }); 

    // detail kelompok 
     $('body').on('click', '.editData', function () {
        let id = $(this).data('id');
        $.get("{{ route('kelompok.detail', ['id' => '']) }}/" + id, function(data, status) {
             
            $('#id').val(data.data.id);
            $('#kel_id').val(data.data.kel_id);
            $('#bid_id').val(data.data.bid_id);
            $('#gol_id').val(data.data.gol_id);
            $('#kelompok').val(data.data.kelompok);
            $('#modalKelompokLabel').html('Edit Kelompok Barang');
 
            $('#modal-add-kelompok').modal('show'); 
        })
    }); 

     // detail sub kelompok 
     $('body').on('click', '.editDataSub', function () {
        let id = $(this).data('id');
        $.get("{{ route('subkelompok.detail', ['id' => '']) }}/" + id, function(data, status) {
             
            $('#id').val(data.data.id);
            $('#subkel_id').val(data.data.subkel_id);
            $('#kel_id').val(data.data.kel_id);
            $('#bid_id').val(data.data.bid_id);
            $('#gol_id').val(data.data.gol_id);
            $('#subkelompok').val(data.data.subkelompok);
            $('#modalSubKelompokLabel').html('Edit Sub Kelompok Barang');
 
            $('#modal-add-subkelompok').modal('show'); 
        })
    }); 

     // detail sub sub kelompok 
     $('body').on('click', '.editDataSubSub', function () {
        let id = $(this).data('id');
        $.get("{{ route('subsubkelompok.detail', ['id' => '']) }}/" + id, function(data, status) {
             
            $('#id').val(data.data.id);
            $('#sub_subkel_id').val(data.data.sub_subkel_id);
            $('#subkel_id').val(data.data.subkel_id);
            $('#kel_id').val(data.data.kel_id);
            $('#bid_id').val(data.data.bid_id);
            $('#gol_id').val(data.data.gol_id);
            $('#sub_subkelompok').val(data.data.sub_subkelompok);
            $('#modalSubSubKelompokLabel').html('Edit Sub Sub Kelompok Barang');
 
            $('#modal-add-subsubkelompok').modal('show'); 
        })
    }); 

    // Delete Kelompok
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
                    url: "{{ route('kelompok.delete', ['id' => '']) }}/" + id,
                    method: 'DELETE', 
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(resp) {
                                
                        if (resp.status == true) {
                            Swal.fire('Success', resp.message, 'success')
                            .then(function(){
                                dtKelompok.ajax.reload(); 
                            })
                        } else {
                            Swal.fire('Error', resp.message, 'error')
                        }
                    }
                }); 
            }
        })
    });

    // Delete Sub Kelompok
    $('body').on('click', '.deleteDataSub', function (e) {
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
                    url: "{{ route('subkelompok.delete', ['id' => '']) }}/" + id,
                    method: 'DELETE', 
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(resp) {
                                
                        if (resp.status == true) {
                            Swal.fire('Success', resp.message, 'success')
                            .then(function(){
                                dtSubKelompok.ajax.reload(); 
                            })
                        } else {
                            Swal.fire('Error', resp.message, 'error')
                        }
                    }
                }); 
            }
        })
    });

    // Delete Sub Sub Kelompok
    $('body').on('click', '.deleteDataSubSub', function (e) {
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
                    url: "{{ route('subsubkelompok.delete', ['id' => '']) }}/" + id,
                    method: 'DELETE', 
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(resp) {
                                
                        if (resp.status == true) {
                            Swal.fire('Success', resp.message, 'success')
                            .then(function(){
                                dtSubSubKelompok.ajax.reload(); 
                            })
                        } else {
                            Swal.fire('Error', resp.message, 'error')
                        }
                    }
                }); 
            }
        })
    });

    $('#modal-add-kelompok').on('hidden.bs.modal', function () { 
        $('#id').val('');
        $('.form-control').val('');
        $('#modalKelompokLabel').html('Tambah Kelompok Barang');
    });

    $('#modal-add-subkelompok').on('hidden.bs.modal', function () { 
        $('#id').val('');
        $('.form-control').val('');
        $('#modalSubKelompokLabel').html('Tambah Sub Kelompok Barang');
    });

    $('#modal-add-subsubkelompok').on('hidden.bs.modal', function () { 
        $('#id').val('');
        $('.form-control').val('');
        $('#modalSubSubKelompokLabel').html('Tambah Sub Sub Kelompok Barang');
    });
</script>

@endpush