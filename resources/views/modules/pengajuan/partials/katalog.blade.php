

<div class="modal fade {{$modal_name}}" tabindex="-1" role="dialog" aria-labelledby="{{$modal_name}}" style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">List Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="{{$table_name}}_fillter" class="mb-4">
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="slcKelompok_{{$table_name}}">Kelompok</label>
                        </div>
                        <select class="custom-select" id="slcKelompok_{{$table_name}}" data-parent=''>
                            <option value="" selected="true">Semua Kelompok Barang</option>
                            @foreach ($kelompok_barang as $kel)
                                <option
                                    value="{{sprintf('%02d', $kel->kel_id).$kel->bid_id.$kel->gol_id}}">
                                    {{$kel->kelompok}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="sclSubKelompok_{{$table_name}}">Sub Kelompok</label>
                        </div>
                        <select class="custom-select" id="sclSubKelompok_{{$table_name}}" data-parent='slcKelompok_{{$table_name}}' >
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
                    <div class="input-group mb-2">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="sclSubSubKelompok_{{$table_name}}">Sub Sub Kelompok</label>
                        </div>
                        <select class="custom-select" id="sclSubSubKelompok_{{$table_name}}"  data-parent='sclSubKelompok_{{$table_name}}'>
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
                <div class="table-responsive">
                    <table class="table table-hover center-aligned-table" id="{{$table_name}}" style="width:100%">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Nama Barang</th>
                                <th>Harga Maksimum</th>
                                <th>Action</th>
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

@push('js')
<script>
      var dt_{{$table_name}} = $('#{{$table_name}}').DataTable({
        processing: true,
        serverSide: true,
        "ajax": {
            "url": "{{ route('data.barangDataTables') }}",
            data: function (d) {
                d.subkel = $('#sclSubKelompok_{{$table_name}}').val()
                d.kel = $('#slcKelompok_{{$table_name}}').val()
                d.subsub = $('#sclSubSubKelompok_{{$table_name}}').val()
            }
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
                data: 'harga_maksimum'
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
                    <button class="btn btn-warning btn-sm" onclick="{{$rowclick}}"><i class="fa fa-shopping-cart"></i></button>
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

    $('#sclSubKelompok_{{$table_name}}, #slcKelompok_{{$table_name}}, #sclSubSubKelompok_{{$table_name}}').change(function(){
        let id = $(this).attr('id');
        let child = $(`#{{$table_name}}_fillter select[data-parent='${id}']`);
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
        dt_{{$table_name}}.draw();
    });
</script>
@endpush
