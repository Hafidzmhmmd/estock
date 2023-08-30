
<script src="{{ asset('/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('/bundles/vendorscripts.bundle.js') }}"></script>

<script src="{{ asset('/bundles/c3.bundle.js') }}"></script>
<script src="{{ asset('/bundles/chartist.bundle.js') }}"></script>
<script src="{{ asset('/vendor/toastr/toastr.js') }}"></script>

<script src="{{ asset('/bundles/mainscripts.bundle.js') }}"></script>
<script src="{{ asset('/js/index.js') }}"></script>
@stack('js_vendor')
<script>
     $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': '{{csrf_token()}}'
        }
    });
</script>
@stack('js')
