<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Cuba admin is super flexible, powerful, clean &amp; modern responsive bootstrap 5 admin template with unlimited possibilities.">
    <meta name="keywords" content="admin template, Cuba admin template, dashboard template, flat admin template, responsive admin template, web app">
    <meta name="author" content="pixelstrap">
    <link rel="icon" href="{{ asset('backend/images/icon1.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('backend/images/icon1.png')}}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <style>.myshadow{
      box-shadow: 0 10px 5px -1px rgba(0,0,0,.2),0 15px 18px 0 rgba(0,0,0,.14),0 1px 14px 0 rgba(0,0,0,.12)!important;
      border-radius: 8px;
    }</style>
    <!-- Google font-->
    <link href="{{ asset('dist/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap')}}" rel="stylesheet">
    <link href="{{ asset('dist/css-1?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome.css')}}">
    <!-- ico-font-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/icofont.css')}}">
    <!-- Themify icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/themify.css')}}">
    <!-- Flag icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/flag-icon.css')}}">
    <!-- Feather icon-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/feather-icon.css')}}">
    <!-- Plugins css start-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/scrollbar.css')}}">
    <!-- Plugins css Ends-->
    <!-- Bootstrap css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/bootstrap.css')}}">
    <!-- App css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{ asset('backend/css/color-1.css')}}" media="screen">
    <!-- Responsive css-->
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{ URL::to('backend/css/toastr.min.css') }}">
		<script src="{{ URL::to('backend/js/toastr_jquery.min.js') }}"></script>
		<script src="{{ URL::to('backend/js/toastr.min.js') }}"></script>
  </head>
  <body>
    <!-- login page start-->
    <div class="container-fluid p-0">
        @yield('content')
        <!-- latest jquery-->
        <script src="{{ asset('backend/js/jquery-3.5.1.min.js')}}"></script>
        <!-- Bootstrap js-->
        <script src="{{ asset('backend/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
        <!-- feather icon js-->
        <script src="{{ asset('backend/js/icons/feather-icon/feather.min.js')}}"></script>
        <script src="{{ asset('backend/js/icons/feather-icon/feather-icon.js')}}"></script>
        <!-- scrollbar js-->
        <!-- Sidebar jquery-->
        <script src="{{ asset('backend/js/config.js')}}"></script>
        <!-- Plugins JS start-->
        <!-- Plugins JS Ends-->
        <!-- Theme js-->
        <script src="{{ asset('backend/js/script.js')}}"></script>
        <!-- login js-->
        <!-- Plugin used-->
    </div>
 </body>
</html>
