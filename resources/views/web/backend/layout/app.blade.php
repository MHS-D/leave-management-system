<!DOCTYPE html>
<html class="loading" lang="ar" data-textdirection="rtl">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <meta name="description"
        content="Vuexy admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
        content="admin template, Vuexy admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="PIXINVENT">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ __('strings.WEBSITE_TITLE') }} - @yield('title')</title>

    <link rel="apple-touch-icon" href="{{ asset('assets/images/ico/apple-icon-120.png') }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/images/ico/favicon.ico') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/vendors.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/charts/apexcharts.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/extensions/toastr.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendors/css/tables/datatable/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/vendors/css/tables/datatable/responsive.bootstrap5.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendors/css/forms/select/select2.min.css') }}">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/bootstrap.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/bootstrap-extended.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/colors.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/components.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/themes/dark-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/themes/bordered-layout.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/themes/semi-dark-layout.css') }}">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/plugins/charts/chart-apex.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/'.loadCssFolder().'/plugins/extensions/ext-component-toastr.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/pages/app-invoice-list.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/plugins/forms/form-validation.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" />
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/'.loadCssFolder().'/loader.css') }}">
    <!-- END: Custom CSS-->

    @stack('style')
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static menu-expanded" data-open="click"
    data-menu="vertical-menu-modern" data-col="" data-framework="laravel" data-asset-path="{{ asset('assets/') }}">

    @includeIf('backend::layout.header.index')

    @includeIf('backend::layout.sidebar.index')

    <!-- BEGIN: Content-->
    <div class="app-content content ">
        <div class="content-overlay"></div>
        <div class="header-navbar-shadow"></div>
        <div class="content-wrapper container-xxl p-0">
            @yield('content')
        </div>
    </div>
    <!-- END: Content-->

    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

    @includeIf('backend::layout.footer')

    @includeIf('backend::layout.scripts')
</body>
<!-- END: Body-->

</html>
