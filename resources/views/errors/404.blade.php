<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <meta name="description" content="POS - Bootstrap Admin Template">
    <meta name="keywords"
        content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern,  html5, responsive">
    <meta name="author" content="Dreamguys - Bootstrap Admin Template">
    <meta name="robots" content="noindex, nofollow">
    <title>Dreams Pos admin template</title>

    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('/assets/img/favicon.png')}}">

    <link rel="stylesheet" href="{{ asset('/assets/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{ asset('/assets/css/animate.css')}}">

    <link rel="stylesheet" href="{{ asset('/assets/css/dataTables.bootstrap4.min.css')}}">

    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{ asset('/assets/plugins/fontawesome/css/all.min.css')}}">

    <link rel="stylesheet" href="{{ asset('/assets/css/style.css')}}">
</head>

<body class="error-page">
    <div id="global-loader">
        <div class="whirly-loader"> </div>
    </div>

    <div class="main-wrapper">
        <div class="error-box">
            <h1>403</h1>
            <h3 class="h2 mb-3"><i class="fas fa-exclamation-circle"></i> Oops! Page Not Found !</h3>
            <p class="h4 font-weight-normal">The page you requested was not found</p>
            <a href="{{ route('admin.dashboard')}}" class="btn btn-primary">Back to Home</a>
        </div>
    </div>


    <script src="{{ asset('/assets/js/jquery-3.6.0.min.js')}}"></script>

    <script src="{{ asset('/assets/js/feather.min.js')}}"></script>

    <script src="{{ asset('/assets/js/jquery.slimscroll.min.js')}}"></script>

    <script src="{{ asset('/assets/js/bootstrap.bundle.min.js')}}"></script>

    <script src="{{ asset('/assets/js/script.js')}}"></script>
</body>

</html>