@extends('_layouts.admin')

@section('content')
    <div class="row">
        <div class="col-3">
            <div class="card">
                <div class="body">
                    <div class="list-group list-widget">
                        @foreach ($gudang as $g)
                            @if ($loop->first)
                                <a href="javascript:void(0);" class="list-group-item text-muted thisgudang"
                                    data-gudangid="{{ $g->id }}">
                                    {{ $g->nama_gudang }}
                                </a>
                            @else
                                <a href="javascript:void(0);" class="list-group-item text-muted"
                                    data-gudangid="{{ $g->id }}">
                                    {{ $g->nama_gudang }}
                                </a>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="card" id="takeoutHolder">
                <h5 class="card-header">Pengambilan Barang</h5>
                <div class="card-body">
                    <div class="list-group list-widget" style="min-height: 200px; max-height:500px; overflow-y:auto">

                    </div>
                    <hr>
                    <button type="button" class="btn btn-block btn-outline-primary" data-toggle="modal"
                        data-target=".form-pengambilan">Proses</button>
                </div>
            </div>
        </div>
        <div class="col-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs">
                        <li class="nav-item"><a class="nav-link active show" data-toggle="tab" href="#list-barang">Stock
                                Gudang</a></li>
                        <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#riwayat">Riwayat</a></li>
                        @if ($pengelolaGudang)
                            <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#transfer">Transfer Stock</a>
                            </li>
                        @endif
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane show active" id="list-barang">
                            <div class="table-responsive">
                                <table class="table m-b-0 table-hover" id="tblstock">
                                    <thead>
                                        <tr>
                                            <th>Uraian</th>
                                            <th>Rencana</th>
                                            <th>Stock</th>
                                            <th>Total</th>
                                            <th>Satuan</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane" id="riwayat">
                            {{-- @include('modules.gudang.form.riwayat',['riwayat' => $riwayat]) --}}
                            <ul class="right_chat list-unstyled mb-0">
                                <li class="offline">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <button type="button" class="btn btn-outline-success m-1" title="Save"><span class="sr-only">Save</span><i class="fa fa-save"></i></button>
                                            <div class="media-body ml-4">
                                                <span class="name">@Isabella <small class="float-right">1 hours ago</small></span>
                                                <span class="message">Contrary to popular belief, Lorem Ipsum is not simply random text</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="offline">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <button type="button" class="btn btn-outline-success m-1" title="Save"><span class="sr-only">Save</span><i class="fa fa-save"></i></button>
                                            <div class="media-body ml-4">
                                                <span class="name">@Isabella <small class="float-right">1 hours ago</small></span>
                                                <span class="message">Contrary to popular belief, Lorem Ipsum is not simply random text</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li class="offline">
                                    <a href="javascript:void(0);">
                                        <div class="media">
                                            <button type="button" class="btn btn-outline-success m-1" title="Save"><span class="sr-only">Save</span><i class="fa fa-save"></i></button>
                                            <div class="media-body ml-4">
                                                <span class="name">@Isabella <small class="float-right">1 hours ago</small></span>
                                                <span class="message">Contrary to popular belief, Lorem Ipsum is not simply random text</span>
                                            </div>
                                        </div>
                                    </a>
                                </li>

                            </ul>
                        </div>
                        @if ($pengelolaGudang)
                            <div class="tab-pane" id="transfer">

                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('modules.gudang.form.pengambilan')
@endsection


@push('js')
    <script>
        var dtBarang = $('#tblstock').DataTable({
            processing: true,
            serverSide: true,
            "ajax": {
                "url": "{{ route('data.stockgudangDataTables') }}",
                data: function(d) {
                    d.gudang_id = $('.thisgudang').attr('data-gudangid')
                }
            },
            columns: [
                // columns according to JSON
                {
                    data: 'uraian'
                },
                {
                    data: 'rencana'
                },
                {
                    data: 'stock'
                },
                {
                    data: ''
                },
                {
                    data: 'satuan'
                },
                {
                    data: ''
                },
            ],
            columnDefs: [{
                    targets: 3,
                    orderable: true,
                    render: function(data, type, full, meta) {
                        let a = parseInt(full.rencana)
                        let b = parseInt(full.stock)
                        if (!isNaN(a) && !isNaN(b)) {
                            return a + b
                        } else {
                            return full.stock;
                        }
                    }
                },
                {
                    // Actions
                    targets: -1,
                    title: 'Actions',
                    orderable: false,
                    render: function(data, type, full, meta) {
                        if (full.stock > 0) {
                            if(full.fifo){
                                return `<button type="button" class="btn btn-primary" onclick="takeout(this)"><i class="icon-plus"></i></button>
                                <button type="button" class="btn btn-outline-info" onclick="childRow(this)"><i class="icon-info"></i></button>`
                            } else {
                                return `<button type="button" class="btn btn-primary" onclick="takeout(this)"><i class="icon-plus"></i></button>`
                            }

                        } else {
                            return '<button type="button" class="btn btn-outline-secondary" disabled><i class="icon-plus"></i></button>';
                        }
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

        function takeout(elm) {
            let row = $(elm).closest('tr');
            let data = dtBarang.row(row).data();
            let target = $("#takeoutHolder .card-body .list-group")
            let exist = target.find(`.takeout-items[data-itemid='${data.barang_id}'][data-gudangid='${data.gudang_id}']`);
            let ct = 1;
            if (exist.length) {
                ct = exist.find('.item-count').html();
                ct = parseInt(ct) + 1
                exist.find('.item-count').html(ct);
            } else {
                let el = `<div class="takeout-items mb-2 border-bottom py-2" data-itemid='${data.barang_id}' data-gudangid='${data.gudang_id}'>
                            <p class="m-0 item-name">${data.uraian}</p>
                            <p class="m-0">Jumlah :</p>
                            <div class="btn-group w-100 mt-2 row_jumlah_barang" style='cursor:pointer'>
                                <button type="button" class="btn btn-outline-secondary w-25" onclick='addStock(this,0)'><i class="fa fa-minus"></i></button>
                                <div class='d-inline-block w-50 text-center p-2 row_jumlah'>
                                    <input type="number" class="form-control row_input_jumlah text-center" style='display:none'>
                                    <span class="m-0  w-75 text-center p-2 ct-data row_label_jumlah" data-max='${data.stock}'>
                                        <span class='item-count'>1</span>
                                        <span class='item-satuan'>${data.satuan}</span>
                                    </span>
                                </div>
                                <button type="button" class="btn btn-outline-secondary w-25" onclick='addStock(this,1)'><i class="fa fa-plus"></i></button>
                            </div>
                        </div>`;
                target.append(el);
            }

            if (ct >= data.stock) {
                $(elm).parent().html(
                    '<button type="button" class="btn btn-outline-secondary" disabled><i class="icon-plus"></i></button>'
                )
            }
        }

        function childRow(elm){
            let row = $(elm).closest('tr');
            let dtrow = dtBarang.row(row);
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
                        let total = parseInt(data.fifo[key].rencana) + parseInt(data.fifo[key].stock);
                        child.push(
                            $(
                                `<tr class="xl-blue">
                                    <td>${key}</td>
                                    <td>${data.fifo[key].rencana}</td>
                                    <td>${data.fifo[key].stock}</td>
                                    <td>${total}</td>
                                    <td>${data.satuan}</td>
                                    <td>${data.fifo[key].tanggal}</td>
                                </tr>`
                            )
                        )
                    });
                    dtrow.child(child).show();
                    row.addClass('shown');
                }
            }

        }

        function addStock(elm, add) {
            $(elm).siblings('div.row_jumlah').find('input.row_input_jumlah').change()
            let target = $(elm).siblings('div.row_jumlah').find('.ct-data')
            console.log(target)
            let ct = target.find('.item-count').html();
            add = add == "1";
            ct = (add) ? parseInt(ct) + 1 : parseInt(ct) - 1;
            let max = parseInt(target.attr('data-max'))
            if (ct >= 0 && ct <= max) {
                target.find('.item-count').html(ct);
            }
        }

        $("#takeoutHolder .card-body .list-group").on('click', '.row_jumlah_barang .row_jumlah', function(){
            let input = $(this).find('.row_input_jumlah');
            let label = $(this).find('.row_label_jumlah');
            let crJml = label.find('.item-count').html()
            if(input.is(":hidden")){
                input.val(crJml).show()
                label.hide()
            }
        })

        $("#takeoutHolder .card-body .list-group").on('change focusout', '.row_input_jumlah', function(){
            let label = $(this).siblings('.row_label_jumlah');
            let crJml = $(this).val();
            let brJml = label.find('.item-count').html();
            let max = parseInt($(this).siblings('.ct-data').attr('data-max'))
            if(label.is(":hidden")){
                if(parseInt(crJml) >= 0 && parseInt(crJml) <= parseInt(max)){
                    label.find('.item-count').html(crJml)
                    label.show()
                    $(this).hide()
                } else {
                    label.show()
                    $(this).hide()
                    swal('Warning', 'Jumlah melebihi stock yang tersedia', 'warning')
                }

            }
        })
    </script>
@endpush
