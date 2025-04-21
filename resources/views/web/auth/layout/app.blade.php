<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr" dir="ltr">
<!-- BEGIN: Head-->

<head>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <link rel="apple-touch-icon" href="{{ asset('assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors-rtl.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/pages/authentication.css') }}">

    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.min.css') }}">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css-ltr/loader.css') }}">

    <link rel="stylesheet" type="text/css" href="assets/css/custom-rtl.css">
    <!-- END: Custom CSS-->

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static   menu-collapsed" data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <div class="auth-wrapper auth-basic px-2">
                    <div class="auth-inner my-2">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Content-->


    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('assets/vendors/js/vendors.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('assets//vendors/js/extensions/toastr.min.js') }}"></script>
    <script src="{{ asset('assets/vendors/js/forms/validation/jquery.validate.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('assets/js/core/app-menu.js') }}"></script>
    <script src="{{ asset('assets/js/core/loader.js') }}"></script>
    <script src="{{ asset('assets/js/core/app.js') }}"></script>
    <!-- END: Theme JS-->

    <!-- BEGIN: Page JS-->
    @stack('scripts')
    <!-- END: Page JS-->

    <script>
        $(window).on('load', function() {
            if (feather) {
                feather.replace({
                    width: 14
                    , height: 14
                });
            }
        })

    </script>
</body>
<!-- END: Body-->

</html>
