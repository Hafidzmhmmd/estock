@extends('_layouts.admin')
@push('css_vendor')
<link rel="stylesheet" href="{{ asset('/vendor/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/bootstrap-multiselect/bootstrap-multiselect.css') }}">
<link rel="stylesheet" href="{{ asset('/vendor/multi-select/css/multi-select.css') }}">
@endpush
@section('content')

<div class="card">
    <div class="card-header bg-white">
        <div class="float-right">
            <button type="button" class="btn btn-outline-primary mb-2" data-toggle="modal" data-target=".modal-barang"><i class="fa fa-plus-circle"></i> Buat</button>
        </div>
        <h5 class="card-title py-2 m-0">Buku Persediaan<b></b>
        </h5>
    </div>
</div>

<div class="card p-4">
    <table class="table table-striped w-100" id="tblLaporan">
        <thead>
          <tr>
            <th scope="col">Tanggal Dibuat</th>
            <th scope="col">Nama Barang</th>
            <th scope="col">Periode</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
        </tbody>
      </table>
</div>
@include('modules.laporan.bukupersediaan.daftarbarang', [
    "modal_name" => "modal-barang",
    "table_name" => "tblbarang",
    "rowclick" => "createBukuPersediaan(this)",
    "subsubkelompok" => $subsubkelompok,
    "kelompok_barang" => $kelompok_barang,
    "subkelompok" => $subkelompok,
])

<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buat Buku Persediaan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="create_laporan_form">
                <div class="form-group">
                    <input type="text" class="form-control itemselected">
                    <input type="text" class="form-control barangidselected" name="barangid" hidden>
                </div>
                <div class="form-group">
                    <label>Pilih Periode :</label>
                    <div class="input-daterange input-group" data-provide="datepicker">
                        <input type="text" class="input-sm form-control" name="date_start">
                        <span class="input-group-addon range-to">sampai</span>
                        <input type="text" class="input-sm form-control" name="date_end">
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="button" class="btn btn-primary laporanbtn">Proses Laporan</button>
        </div>
      </div>
    </div>
</div>

@endsection
@push('js_vendor')
<script src="{{ asset('/vendor/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('/vendor/bootstrap-multiselect/bootstrap-multiselect.js') }}"></script>
@endpush
@push('js')
    <script>
        $('.input-daterange input').each(function() {
            $(this).datepicker({
                todayHighlight : true,
                format: {
                    toDisplay: function (date, format, language) {
                        let d = new Date(date);
                        let year = d.getFullYear();
                        let month = d.getMonth()+1;
                        let dt = d.getDate();
                        if (dt < 10) {
                            dt = '0' + dt;
                        }
                        if (month < 10) {
                            month = '0' + month;
                        }

                        let fulldate = `${dt}/${month}/${year}`

                        return fulldate;
                    },
                    toValue: function (date, format, language) {
                        let d = new Date(date);
                        let year = d.getFullYear();
                        let month = d.getMonth()+1;
                        let dt = d.getDate();
                        if (dt < 10) {
                            dt = '0' + dt;
                        }
                        if (month < 10) {
                            month = '0' + month;
                        }

                        let fulldate = `${dt}/${month}/${year}`

                        return fulldate;
                    }
                }
            });
        });
        function createBukuPersediaan(e){
            let row = $(e).closest('tr');
            let data = dt_tblbarang.row(row).data()
            console.log(data)
            let uraian = data.uraian
            let barangid = data.id
            $("#modalCreate .itemselected").val(uraian)
            $("#modalCreate .barangidselected").val(barangid)
            $("#modalCreate").modal('show')
        }

        $(".laporanbtn").click(function(){
            let frm = new FormData($('#create_laporan_form')[0])
            $.ajax({
                url: "{{route('laporan.bukupersediaan')}}",
                data: frm,
                cache: false,
                processData: false,
                contentType: false,
                type: 'POST',
                success: function (response) {
                    if(response.status){
                        $('#modalCreate').modal('hide');
                        Swal.fire('Success', 'Buku persediaan berhasil dibuat', 'success');
                        dt.ajax.reload();
                    } else {
                        Swal.fire('Error', 'terjadi kesalahan', 'error');
                    }
                }
            });
        })

        var dt = $('#tblLaporan').DataTable({
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ route('laporan.listBukuPersediaan') }}",
            },
            fnDrawCallback: function() {
                closeAjaxLoader();
            },
            columns: [
                {
                    data: 'created_at'
                },
                {
                    data: 'nama_barang'
                },
                {
                    data: 'periode'
                },
                {
                    data: '',
                    class: 'text-center'
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
                        <button class="btn btn-warning btn-sm" onclick="viewLaporan('${full.path}')"><i class="fa fa-file-pdf-o"></i></button>
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

        function viewLaporan(path){
            $.fancybox.open({
                src  :  '{{env('APP_URL')}}/getfile/'+path,
                type : 'iframe',
                opts : {
                    afterShow : function( instance, current ) {

                    }
                }
            });
        }
    </script>
@endpush
