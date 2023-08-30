<!doctype html>
<html lang="en">

<head>
<title>:: HexaBit :: Login</title>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=Edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
<meta name="description" content="HexaBit Bootstrap 4x Admin Template">
<meta name="author" content="WrapTheme, www.thememakker.com">

<link rel="icon" href="favicon.ico" type="image/x-icon">
<!-- VENDOR CSS -->
<link rel="stylesheet" href="{{ asset('/vendor/bootstrap/css/bootstrap.min.css')}}">
<link rel="stylesheet" href="{{ asset('/vendor/font-awesome/css/font-awesome.min.css')}}">

<!-- MAIN CSS -->
<link rel="stylesheet" href="{{ asset('/css/app.css') }}">
<link rel="stylesheet" href="{{ asset('/css/color_skins.css') }}">
<style>
    .theme-orange .auth-main::after{
        background-image: url("{{ asset('/images/landscapeDKI.jpg') }}");
        background-position: center;
        background-repeat: no-repeat;
        background-size: cover;
        box-shadow: inset 0 0 0 2000px rgba(238, 161, 19, 0.7);
    }
</style>
</head>

<body class="theme-orange">
    <!-- WRAPPER -->
    <div id="wrapper" class="auth-main m-0">
        <div class="float-right col-md-4" style="background-color: #380e47; height:100vh">
            <div class="card" style="margin-top: 300px">
                <div class="header">
                    <p class="lead">Login to your account</p>
                </div>
                <div class="body">
                    <form class="form-auth-small" id="formlogin">
                        <div class="form-group">
                            <label for="signin-email" class="control-label sr-only">Email</label>
                            <input type="email" class="form-control" id="signin-email" value="" placeholder="username">
                        </div>
                        <div class="form-group">
                            <label for="signin-password" class="control-label sr-only">Password</label>
                            <input type="password" class="form-control" id="signin-password" value="" placeholder="Password">
                        </div>
                        <div class="form-group clearfix">
                            <label class="fancy-checkbox element-left">
                                <input type="checkbox">
                                <span>Remember me</span>
                            </label>
                        </div>
                        <button id="btnlogin" type="button" class="btn btn-primary btn-lg btn-block">LOGIN</button>
                        <div class="bottom">
                            <span class="helper-text m-b-10"><i class="fa fa-lock"></i><a href="page-forgot-password.html">Forgot password?</a></span>
                            <span>Don't have an account? <a href="page-register.html">Register</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- END WRAPPER -->
<script src="{{ asset('/bundles/libscripts.bundle.js') }}"></script>
<script src="{{ asset('/bundles/vendorscripts.bundle.js') }}"></script>
<script src="{{ asset('/bundles/mainscripts.bundle.js') }}"></script>

<script>
    $("#btnlogin").click(function(){
        const formData = new FormData();
        formData.append('username', $("#signin-email").val())
        formData.append('password', $("#signin-password").val())
        xhr = new XMLHttpRequest();
        xhr.withCredentials = false;
        xhr.open('POST', '{{ route('dologin') }}');
        xhr.setRequestHeader("X-CSRF-TOKEN", '{{ csrf_token() }}');
        xhr.onload = function () {
            let response = JSON.parse(xhr.responseText);
            if(response.status){
                window.location.href = response.url;
            }
        };
        xhr.onerror = function () {
            console.log('err')
        }
        xhr.send(formData);
    })
</script>
</body>
</html>
