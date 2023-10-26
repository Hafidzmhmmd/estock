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
            <button type="button" class="btn btn-outline-primary mb-2" data-toggle="modal" data-target="#modalCreate"><i class="fa fa-plus-circle"></i> Tambah</button>
        </div>
        <h5 class="card-title py-2 m-0">Laporan Opname<b></b>
        </h5>
        <hr>
        <div class="pb-3">
            <div class="form-row">
                <div class="col px-3">
                    <label for="inputState">Tahun</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="col px-3">
                    <label for="inputState">Jenis Laporan</label>
                    <select id="inputState" class="form-control">
                        <option selected>Choose...</option>
                        <option>...</option>
                    </select>
                </div>
                <div class="col px-3">
                    <label for="inputState">Pencarian</label>
                    <input type="text" class="form-control" placeholder="Judul Laporan">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card p-4">
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Judul Laporan</th>
            <th scope="col">Tanggal Dibuat</th>
            <th scope="col">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <th scope="row">1</th>
            <td>Mark</td>
            <td>Otto</td>
            <td>@mdo</td>
          </tr>
        </tbody>
      </table>
</div>

<div class="modal fade" id="modalCreate" tabindex="-1" role="dialog" aria-labelledby="modalCreate" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buat Laporan</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="create_laporan_form">
                <div class="form-group">
                    <label>Tanggal Laporan</label>
                    <div class="input-daterange input-group" data-provide="datepicker">
                        <input type="text" class="input-sm form-control" name="date_start">
                        <span class="input-group-addon range-to">sampai</span>
                        <input type="text" class="input-sm form-control" name="date_end">
                    </div>
                </div>
                <div class="form-group">
                    <label>Gudang</label>
                    <div class="multiselect_div">
                        <select id="multiselect" name="gudang[]" class="multiselect multiselect-custom" multiple="multiple">
                            @foreach ($gudang as $key=>$value)
                                <option value="{{$value}}">{{$key}}</option>
                            @endforeach
                        </select>
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
    // Multiselect
    $('#multiselect').multiselect({
        maxHeight: 300,
        includeSelectAllOption: true,
    });
    $("#multiselect").multiselect('selectAll', false);
    $("#multiselect").multiselect('updateButtonText');

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

    $('#modalCreate .laporanbtn').click(function(){
        let frm = new FormData($('#create_laporan_form')[0])
        $.ajax({
            url: "{{route('laporan.opname')}}",
            data: frm,
            cache: false,
            processData: false,
            contentType: false,
            type: 'POST',
            success: function (response) {
                console.log(response)
            }
        });
    })
</script>
@endpush
