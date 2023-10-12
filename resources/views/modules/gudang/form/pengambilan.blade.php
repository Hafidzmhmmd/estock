<div class="modal fade form-pengambilan" tabindex="-1" role="dialog" aria-labelledby="form-pengambilan"
    style="display: none;" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title h4">Ringkasan Pengambilan</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="table-responsive">
                    <table class="table table-striped" id="takeoutSum">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Uraian</th>
                                <th>Jumlah</th>
                                <th>Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <hr>
                <label for="ket_pengambilan">Keterangan :</label>
                <textarea class="form-control" aria-label="With textarea" id="ket_pengambilan" rows="5"></textarea>
                <hr>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-outline-primary btnprosess"
                        onclick="takeout_proccess()">Proses
                        Pengambilan</button>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
    <script>
        $('.form-pengambilan').on('show.bs.modal', function(e) {
            $("#takeoutSum tbody").html('');
            let idx = 1;
            $("#takeoutHolder .takeout-items").each(function() {
                let name = $(this).find('.item-name').html()
                let ct = $(this).find('.item-count').html()
                let satuan = $(this).find('.item-satuan').html()
                let itemid = $(this).attr('data-itemid')
                let gudangid = $(this).attr('data-gudangid')
                let intCt = parseInt(ct);
                if (intCt) {
                    $("#takeoutSum tbody").append(`
                        <tr data-barangid=${itemid} data-gudangid=${gudangid}>
                            <th scope="row">${idx}</th>
                            <td class='name'>${name}</td>
                            <td class='jml'>${ct}</td>
                            <td class='satuan'>${satuan}</td>
                        </tr>
                    `)
                    idx++;
                }
            })
            let trct = $("#takeoutSum tbody tr").length;
            if (!trct) {
                $(".form-pengambilan .btnprosess").prop('disabled', true);
            } else {
                $(".form-pengambilan .btnprosess").prop('disabled', false);
            }
        })

        function takeout_proccess() {
            let ct = $("#takeoutSum tbody tr").length;
            if (ct) {
                swal({
                    title: `<i class="fa fa-spinner fa-spin"></i>`,
                    text: "Memproses pengambilan...",
                    html: true,
                    showCancelButton: false,
                    showConfirmButton: false,
                });

                let data = {};
                $("#takeoutSum tbody tr").each(function() {
                    let gudangid = $(this).attr('data-gudangid')
                    let barangid = $(this).attr('data-barangid')
                    let ct = $(this).find('.jml').html();
                    if (!data[gudangid]) {
                        data[gudangid] = [];
                    }
                    data[gudangid].push({
                        "barang_id": barangid,
                        "jumlah": parseInt(ct)
                    })
                })

                $.post("{{ route('gudang.takeout') }}", {
                        "takeout": data
                    },
                    function(data, status) {
                        if (data.status) {
                            swal("Berhasil!", "proses pengambilan barang berhasil di catat", "success")
                            $('.form-pengambilan').modal('hide')
                            dtBarang.draw();
                            $("#takeoutHolder .card-body .list-group").html('')
                        } else {
                            swal("Gagal!", "gagal melakukan pengambilan barang!", "warning")
                        };
                    });
            }
        }
    </script>
@endpush
