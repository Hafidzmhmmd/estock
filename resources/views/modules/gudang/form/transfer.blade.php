<div class="modal fade" id="transferModal" tabindex="-1" role="dialog" aria-labelledby="transferModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document" style="min-width:80vw">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Transfer Barang</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="transfer-form" class="row">
                <div class="source-gudang col-6">
                    <div class="form-group">
                        <label class="my-1 mr-2">Pilih Gudang Asal</label>
                        <select class="custom-select my-1 mr-sm-2 slc-gudang-transfer" data-tbltarget="source-tbl" data-direction='icon-action-redo'>
                          <option selected disabled>Pilih...</option>
                          @foreach ($gudang as $g)
                                    <option value='{{$g->id}}'>{{$g->nama_gudang}}</option>
                                @endforeach
                        </select>
                    </div>
                    <div class="list-barang">
                        <table class="table table-striped" id="source-tbl">
                            <thead>
                                <tr>
                                    <th class="w-50">Uraian</th>
                                    <th class="w-25">Jumlah</th>
                                    <th class="w-25 text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="destination-gudang col-6">
                    <div class="form-group">
                        <label class="my-1 mr-2">Pilih Gudang Tujuan</label>
                        <select class="custom-select my-1 mr-sm-2 slc-gudang-transfer" data-tbltarget="destination-tbl" data-direction='icon-action-undo'>
                            <option selected disabled>Pilih...</option>
                          @foreach ($gudang as $g)
                            <option value='{{$g->id}}'>{{$g->nama_gudang}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="list-barang">
                        <table class="table table-striped" id="destination-tbl">
                            <thead>
                                <tr>
                                    <th class="w-50">Uraian</th>
                                    <th class="w-25">Jumlah</th>
                                    <th class="w-25 text-center">#</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>

@push('js')
 <script>
    $('.slc-gudang-transfer').change(function(){
        let tval = $(this).val()
        let dt = $(this).attr('data-tbltarget')
        $(`.slc-gudang-transfer option`).show();
        let otherval = $(`.slc-gudang-transfer[data-tbltarget!='${dt}']`).val()
        if(tval){
            $(`.slc-gudang-transfer[data-tbltarget!='${dt}'] option[value='${tval}']`).hide()
            if(otherval){
                $(`.slc-gudang-transfer[data-tbltarget='${dt}'] option[value='${otherval}']`).hide()
            }
            createDatatable(dt)
        }
    })

    const createdDt = {
        'source-tbl' : false,
        'destination-tbl' : false,
    }
    function createDatatable(id){
        if(!createdDt[id]){
            createdDt[id] = $(`#${id}`)
            .on('preXhr.dt', function ( e, settings, data ) {
                ajaxLoader();
            })
            .DataTable({
                processing: true,
                serverSide: true,
                responsive: true,
                bLengthChange: false,
                searching: false,
                pageLength: 5,
                "ajax": {
                    "url": "{{ route('data.stockgudangDataTables') }}",
                    data: function(d) {
                        let gid = $(`.slc-gudang-transfer[data-tbltarget='${id}']`).val()
                        d.gudang_id = gid
                    },
                },
                fnDrawCallback: function() {
                    closeAjaxLoader();
                },
                columns: [
                    // columns according to JSON
                    {
                        data: 'uraian'
                    },
                    {
                        data: ''
                    },
                    {
                        data: '',
                        class: 'text-center'
                    },
                ],
                columnDefs: [{
                        targets: 1,
                        orderable: true,
                        render: function(data, type, full, meta) {
                            let a = parseInt(full.rencana)
                            let b = parseInt(full.stock)
                            if (!isNaN(a) && !isNaN(b)) {
                                return a + b + ' ' + full.satuan
                            } else {
                                return full.stock+ ' ' + full.satuan;
                            }
                        }
                    },
                    {
                        // Actions
                        targets: -1,
                        title: 'Actions',
                        orderable: false,
                        render: function(data, type, full, meta) {
                            let icon = $(`.slc-gudang-transfer[data-tbltarget='${id}']`).attr('data-direction')
                            if (full.stock > 0) {
                                if(full.fifo){
                                    return `<button type="button" class="btn btn-outline-info" onclick="trfChildRow(this, '${id}')"><i class="icon-info"></i></button>&nbsp;`
                                    + `<button type="button" class="btn btn-primary" onclick="transferThis(this, '${id}')"><i class="${icon}"></i></button>`
                                }
                                else {
                                    return`<button type="button" class="btn btn-primary" onclick="transferThis(this, '${id}')"><i class="${icon}"></i></button>`
                                }

                            } else {
                                return '<button type="button" class="btn btn-outline-secondary" disabled><i class="icon-plus"></i></button>';
                            }
                        }
                    }
                ],
                order: [
                    [0, 'asc']
                ],
                dom: '<"d-flex justify-content-between align-items-center header-actions mx-1 row mt-75"' +
                    '<"col-lg-12 col-xl-12 pl-xl-75 pl-0"<"dt-action-buttons text-xl-right text-lg-left text-md-right text-left d-flex align-items-center justify-content-lg-end align-items-center flex-sm-nowrap flex-wrap mr-1"<"mr-1"f>>>' +
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
        } else {
            createdDt[id].ajax.reload();
        }
    }

    function trfChildRow(elm, src){
        let row = $(elm).closest('tr');
        let dtrow =  createdDt[src].row(row);
        let data = dtrow.data();
        if (dtrow.child.isShown() ) {
            dtrow.child.hide();
            row.removeClass('shown')
        } else {
            dtBarang.rows().every( function () {
                this.child.hide();
            });
            let child = [];
            if(data.fifo){
                Object.keys(data.fifo).forEach(key => {
                    console.log(data.fifo[key])
                    let total = parseInt(data.fifo[key].rencana) + parseInt(data.fifo[key].stock);
                    let icon = $(`.slc-gudang-transfer[data-tbltarget='${src}']`).attr('data-direction')
                    child.push(
                        $(
                            `<tr class="xl-blue">
                                <td>${data.fifo[key].tanggal}</td>
                                <td>${total} ${data.satuan}</td>
                                <td class='text-center'>-</td>
                            </tr>`
                        )
                    )
                });
                dtrow.child(child).show();
                row.addClass('shown');
            }
        }

    }

    function transferThis(elm, src){
        let fromGudang = $(`.slc-gudang-transfer[data-tbltarget = '${src}']`).val();
        let toGudang = $(`.slc-gudang-transfer[data-tbltarget != '${src}']`).val();
        let row = $(elm).closest('tr');
        let data = createdDt[src].row(row).data();
        console.log(data)
        if(fromGudang && toGudang){
            swal({
                title: "Jumlah Transfer",
                text: "Write something interesting:",
                type: "input",
                showCancelButton: true,
                closeOnConfirm: false,
                animation: "slide-from-top",
                inputPlaceholder: "Write something"
            },
            function(inputValue){
                if (inputValue === null) return false;

                if (inputValue === "") {
                    swal('Warning', 'Masukan Jumlah!', 'warning')
                    return false
                }
                ajaxLoader();
                $.ajax({
                    type: "POST",
                    url: "{{route('gudang.transfer')}}",
                    data: {
                        asalGudang : fromGudang,
                        tujuanGudang : toGudang,
                        barangId : data.barang_id,
                        jumlah : inputValue
                    },
                    success: function(response){
                        if(response.status){
                            swal('Berhasil', 'Transfer barang berhasil', 'success')
                            Object.keys(createdDt).forEach(dt => {
                                if(createdDt[dt]){
                                    createdDt[dt].ajax.reload( null, false);
                                }
                            })
                        } else {
                            swal('Warning', response.message, 'warning')
                        }
                    }
                })
            });
        } else {
            swal('Warning', 'Pilih asal gudang dan tujuan gudang', 'warning')
        }
    }
 </script>
@endpush
