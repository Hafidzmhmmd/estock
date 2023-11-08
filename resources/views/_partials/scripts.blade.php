
<script src="{{ asset('/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('/bundles/vendorscripts.bundle.js') }}"></script>

<script src="{{ asset('/bundles/c3.bundle.js') }}"></script>
<script src="{{ asset('/bundles/chartist.bundle.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.js') }}"></script>

<script src="{{ asset('/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('/js/index.js') }}"></script>

<script src="{{ asset('/vendor/repeater/jquery.repeater.min.js') }}"></script>
<script src="{{ asset('/vendor/sweetalert/sweetalert.min.js') }}"></script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/fancybox@3.5.6/dist/jquery.fancybox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@stack('js_vendor')
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });

    function ajaxLoader(text){
        let txt = text ?? 'Memproses....'
        Swal.fire({
            text: txt,
            allowOutsideClick: false,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
            },
        });
    }

    function closeAjaxLoader(){
        swal.close()
    }
    $.fn.modal.Constructor.prototype._enforceFocus = function() {};
</script>
@stack('js')
