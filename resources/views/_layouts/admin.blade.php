<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>{{config('app.name')}}</title>
        <link rel="icon" href="favicon.ico" type="image/x-icon">
        <link rel="stylesheet" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/vendor/font-awesome/css/font-awesome.min.css') }}">

        <link rel="stylesheet" href="{{ asset('/vendor/charts-c3/plugin.css') }}"/>
        <link rel="stylesheet" href="{{ asset('/vendor/bootstrap-progressbar/css/bootstrap-progressbar-3.3.4.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/vendor/chartist/css/chartist.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/vendor/chartist-plugin-tooltip/chartist-plugin-tooltip.css') }}">
        <link rel="stylesheet" href="{{ asset('/vendor/toastr/toastr.min.css') }}">

        <link rel="stylesheet" href="{{ asset('/css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/color_skins.css') }}">

        <link rel="stylesheet" href="{{ asset('/vendor/sweetalert/sweetalert.css') }}">
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <link href="https://cdnjs.com/libraries/select2-bootstrap-theme/" rel="stylesheet" />
    </head>
    <body class="theme-orange">
        <div id="wrapper">
            @include('_partials.headerbar')
            @include('_partials.sidebar')

            <div id="main-content" class="pt-4">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        @include('_partials.scripts')
    </body>
</html>
