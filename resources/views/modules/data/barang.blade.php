@extends('_layouts.admin')

@section('content')
<div class="card">
    <div class="card-body">
        <button type="button" class="btn btn-primary btn-round float-right">Tambah Data</button>
        <h5 class="card-title">Pengaturan Data Barang</h5>
        <hr>
        <div class="row">
            <div class="col-4">
                <div class="form-group">
                    <label for="sclSubKelompok">Sub Kelompok</label>
                    <select class="form-control" id="sclSubKelompok">
                        <option value="" selected="true" disabled="disabled">[Pilih Kelompok Barang]</option>
                        @foreach ($subkelompok as $subkel)
                            <option value="{{$subkel->subkel_id}}">{{$subkel->subkelompok}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="slcKelompok">Kelompok</label>
                    <select class="form-control" id="slcKelompok">
                        <option value="" selected="true" disabled="disabled">[Pilih Kelompok Barang]</option>
                        @foreach ($kelompok_barang as $kel)
                            <option value="{{$kel->kel_id}}">{{$kel->kelompok}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <label for="slcBidang">Bidang</label>
                    <select class="form-control" id="slcBidang">
                        <option value="" selected="true" disabled="disabled">[Pilih Bidang Barang]</option>
                        @foreach ($bidang_barang as $bid)
                            <option value="{{$bid->bid_id}}">{{$bid->bidang}}</option>
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
                    <th>Kode</th>
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
        "ajax": {
            "url": "{{ route('data.barangDataTables') }}",
        },
        columns: [
            // columns according to JSON
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
            // {
            //     // For Responsive
            //     className: 'control',
            //     orderable: false,
            //     responsivePriority: 2,
            //     targets: 0,
            //     render: function(data, type, full, meta) {
            //         if (data) {
            //             return `<div class="badge badge-primary">${data}</div>`
            //         } else return data
            //     }
            // },
            // {
            //     targets: 6,
            //     orderable: false,
            //     render: function(data, type, full, meta) {
            //         var className = 'primary'
            //         if (data === 'Draft') {
            //             className = 'light-warning'
            //         }
            //         return `<div class="badge badge-${className}">${data}</div>`
            //     }
            // },
            {
                // Actions
                targets: 3,
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
            [1, 'desc']
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
            // Adding role filter once table initialized
            // this.api()
            //     .columns(2)
            //     .every(function() {
            //         var column = this;
            //         var select = $(
            //                 '<select id="filter-kepemilikan" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Filter Kepemilikan </option></select>'
            //             )
            //             .appendTo('.filter-kepemilikan')
            //             .on('change', function() {
            //                 var val = $.fn.dataTable.util.escapeRegex($(this).val());
            //                 column.search(val ? '^' + val + '$' : '', true, false).draw();
            //             });

            //         column
            //             .data()
            //             .unique()
            //             .sort()
            //             .each(function(d, j) {
            //                 if (d)
            //                     select.append('<option value="' + d + '" class="text-capitalize">' +
            //                         d + '</option>');
            //             });
            //     });
            // // Adding plan filter once table initialized
            // this.api()
            //     .columns(6)
            //     .every(function() {
            //         var column = this;
            //         var select = $(
            //                 '<select id="filter_status" class="form-control text-capitalize mb-md-0 mb-2"><option value=""> Filter Status Permohonan </option></select>'
            //             )
            //             .appendTo('.filter_status')
            //             .on('change', function() {
            //                 var val = $.fn.dataTable.util.escapeRegex($(this).val());
            //                 column.search(val ? '^' + val + '$' : '', true, false).draw();
            //             });

            //         column
            //             .data()
            //             .unique()
            //             .sort()
            //             .each(function(d, j) {
            //                 select.append('<option value="' + d + '" class="text-capitalize">' + d +
            //                     '</option>');
            //             });
            //     });

        }
    });
</script>

@endpush
