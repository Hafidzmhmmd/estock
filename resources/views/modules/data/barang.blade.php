@extends('_layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-round float-right">Tambah Data</button>
        <h5 class="card-title">Pengaturan Data Barang</h5>
        <hr>
        <div class="row" id="filtertable">
            <div class="col-4">
                <div class="form-group">
                    <label for="sclSubSubKelompok">Sub Sub Kelompok</label>
                    <select class="form-control" id="sclSubSubKelompok"  data-parent='sclSubKelompok'>
                        <option value="" selected="true">Semua Sub Sub Kelompok Barang</option>
                        @foreach ($subsubkelompok as $subsub)
                            <option data-parent='{{str_pad($subsub->subkel_id,2,'0',STR_PAD_LEFT)}}' value="{{str_pad($subsub->sub_subkel_id,3,'0',STR_PAD_LEFT)}}">{{$subsub->sub_subkelompok}}</option>
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
                            <option data-parent="{{str_pad($subkel->kel_id,2,'0',STR_PAD_LEFT)}}" value="{{str_pad($subkel->subkel_id,2,'0',STR_PAD_LEFT)}}">{{$subkel->subkelompok}}</option>
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
                            <option value="{{str_pad($kel->kel_id,2,'0',STR_PAD_LEFT)}}">{{$kel->kelompok}}</option>
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
                render: function(data, type, full, meta) {
                    return (`
                    <button class="btn btn-warning btn-sm"><i class="icon-pencil"></i></button>
                    <button class="btn btn-danger btn-sm"><i class="icon-trash"></i></button>
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
</script>

@endpush
