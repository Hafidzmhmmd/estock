@extends('_layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <button type="button" data-toggle="modal" data-target="#modal-add-barang" class="btn btn-primary btn-round float-right">Tambah Data</button>
        <h5 class="card-title">Pengaturan Data Barang</h5>
        <hr>
        <div class="row" id="filtertable">
            <div class="col-4">
                <div class="form-group">
                    <label for="sclSubSubKelompok">Sub Sub Kelompok</label>
                    <select class="form-control" id="sclSubSubKelompok"  data-parent='sclSubKelompok'>
                        <option value="" selected="true">Semua Sub Sub Kelompok Barang</option>
                        @foreach ($subsubkelompok as $subsub)
                        <option
                                data-parent='{{sprintf('%02d', $subsub->subkel_id).$subsub->kel_id.$subsub->bid_id.$subsub->gol_id}}'
                                value="{{sprintf('%03d', $subsub->sub_subkel_id).$subsub->subkel_id.$subsub->kel_id.$subsub->bid_id.$subsub->gol_id}}">
                                {{$subsub->sub_subkelompok}}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="sclSubKelompok">Sub Kelompok</label>
                    <select class="form-control" id="sclSubKelompok" data-parent='slcKelompok' >
                        <option value="" selected="true">Semua Sub Kelompok Barang</option>
                        @foreach ($subkelompok as $subkel)
                            <option
                                data-parent="{{sprintf('%02d', $subkel->kel_id).$subkel->bid_id.$subkel->gol_id}}"
                                value="{{sprintf('%02d', $subkel->subkel_id).$subkel->kel_id.$subkel->bid_id.$subkel->gol_id}}">
                                {{$subkel->subkelompok}}
                                </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="slcKelompok">Kelompok</label>
                    <select class="form-control" id="slcKelompok" data-parent=''>
                        <option value="" selected="true">Semua Kelompok Barang</option>
                        @foreach ($kelompok_barang as $kel)
                        <option
                            value="{{sprintf('%02d', $kel->kel_id).$kel->bid_id.$kel->gol_id}}">
                            {{$kel->kelompok}}
                        </option>
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
        </ul>
    </div>
    <div class="body">
        <div class="table-responsive">
            <table class="table center-aligned-table" id="tblBarang">
                <thead>
                <tr>
                    <th width='15%'>Sub Sub Kelompok</th>
                    <th width='15%'>Kode</th>
                    <th>Uraian</th>
                    <th>Satuan</th>
                    {{-- <th>Harga Maksimum</th> --}}
                    <th></th>
                </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- modal add barang --}}
<div class="modal fade" id="modal-add-barang" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="title" id="modalBarangLabel">Tambah Barang</h4>
            </div>
            <form id="form_add_barang" method="POST" action="javascript:void(0)">
                <input type="hidden" id="idbarang" name="idbarang">
                <div class="modal-body">
                    <div class="row" id="filteradd">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="golongan">Golongan</label>
                                <select class="form-control" id="golongan" name="golongan" data-parent=''>
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
                                <label for="bidang">Bidang</label>
                                <select class="form-control" id="bidang" name="bidang" data-parent='golongan' >
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
                    <div class="row" id="filteradd"> 
                        <div class="col-4">
                            <div class="form-group">
                                <label for="kel">Kelompok</label>
                                <select class="form-control" id="kel" name="kel" data-parent=''>
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
                        <div class="col-4">
                            <div class="form-group">
                                <label for="subkel">Sub Kelompok</label>
                                <select class="form-control" id="subkel" name="subkel" data-parent='kel' >
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
                        <div class="col-4">
                            <div class="form-group">
                                <label for="sub_subkel">Sub Sub Kelompok</label>
                                <select class="form-control" id="sub_subkel" name="sub_subkel"  data-parent='subkel'>
                                    <option value="" selected="true">Semua Sub Sub Kelompok Barang</option>
                                    @foreach ($subsubkelompok as $subsub)
                                    <option
                                            data-parent='{{sprintf('%02d', $subsub->subkel_id)}}'
                                            value="{{sprintf('%03d', $subsub->sub_subkel_id)}}">
                                            {{$subsub->sub_subkelompok}}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div> 
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="kode">Kode</label>
                                <input type="number" id="kode" name="kode" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="uraian">Uraian</label>
                                <input type="text" id="uraian" name="uraian" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="satuan">Satuan</label>
                                <select class="form-control" id="satuan" name="satuan">
                                    <option value="">Pilih Satuan</option>
                                    <option value="Buah">Buah</option>
                                    <option value="Dus">Dus</option>
                                    <option value="Lusin">Lusin</option>
                                    <option value="Pak">Pak</option>
                                    <option value="Pak/Box">Pak/Box</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Pcs/Buah">Pcs/Buah</option>
                                    <option value="Rim">Rim</option>
                                    <option value="Rol">Rol</option>
                                    <option value="Set">Set</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="harga_maksimum">Harga Maksimum</label>
                                <input type="number" id="harga_maksimum" name="harga_maksimum" class="form-control" required>
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
    var dtBarang = $('#tblBarang').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.barangDataTables') }}",
            data: function (d) {
                d.subkel = $('#sclSubKelompok').val()
                d.kel = $('#slcKelompok').val()
                d.subsub = $('#sclSubSubKelompok').val()
            }
        },
        columns: [
            // columns according to JSON
            {
                data: 'subsubkelompok'
            },
            {
                data: 'kode'
            },
            {
                data: 'uraian'
            },
            {
                data: 'satuan'
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

    $('#sclSubKelompok, #slcKelompok, #sclSubSubKelompok').change(function(){
        let id = $(this).attr('id');
        let child = $(`#filtertable select[data-parent='${id}']`);
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
        dtBarang.draw();
    });

    $('#kel, #subkel, #sub_subkel, #golongan, #bidang').change(function(){
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

    // Add barang
    $('#form_add_barang').submit(function(e){
        e.preventDefault(); 

        let frmData = new FormData($(this)[0]); 

        $('#submitButton').attr('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...');
            
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            url: '{{route('barang.store')}}',
            method: 'POST',
            data: frmData,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(resp) { 
                $('#submitButton').attr('disabled', false).html('Simpan');
                if(resp.status == true){
                    Swal.fire('Success', resp.message, 'success')
                    $('#modal-add-barang').modal('hide'); 
                    dtBarang.ajax.reload(); 
                }else{
                   Swal.fire('Error', resp.message, 'error')
                }
            }
        }); 
    });

    // detail barang 
     $('body').on('click', '.editData', function () {
        let id = $(this).data('id');
        $.get("{{ route('barang.detail', ['id' => '']) }}/" + id, function(data, status) {
            
            $('#golongan').val(data.data.gol_id).trigger('change'); 
            $('#bidang').val(data.data.bid_id).trigger('change'); 
            $('#kel').val(data.data.kel_id).trigger('change');  
            $('#subkel').val(data.data.subkel_id).trigger('change');  
            $('#sub_subkel').val(data.data.sub_subkel_id).trigger('change');  
            $('#kode').val(data.data.kode);
            $('#uraian').val(data.data.uraian); 
            $('#satuan').val(data.data.satuan); 
            $('#harga_maksimum').val(data.data.harga_maksimum);   
            $('#idbarang').val(data.data.id);

            $('#modalBarangLabel').html('Edit Barang');
 
            $('#modal-add-barang').modal('show'); 
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
                    url: "{{ route('barang.delete', ['id' => '']) }}/" + id,
                    method: 'DELETE', 
                    contentType: false,
                    processData: false,
                    dataType: "JSON",
                    success: function(resp) {
                                
                        if (resp.status == true) {
                            Swal.fire('Success', resp.message, 'success')
                            .then(function(){
                                dtBarang.ajax.reload(); 
                            })
                        } else {
                            Swal.fire('Error', resp.message, 'error')
                        }
                    }
                }); 
            }
        })
    });

    $('#modal-add-barang').on('hidden.bs.modal', function () { 
        $('#id').val('');
        $('.form-control').val('');
        $('#modalBarangLabel').html('Tambah Barang');
    });
</script>

@endpush
