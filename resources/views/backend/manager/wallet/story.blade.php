@extends('layouts.master')
@push('style')
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Portefeuille numérique à la pointe de la technologie, Emala vous permet de faire des transactions financières sécurisées.">
    <meta name="keywords" content="EMALA, Emala, emala, emalafintech, fintech">
    <meta property="og:image" content="http://dashboard.emalafintech.net/assets/img/logo.png" />
    <meta property="og:image:secure_url" content="https://dashboard.emalafintech.net/assets/img/logo.png" />
    <meta property="og:image:type" content="image/png" />
    <meta property="og:image:width" content="400" />
    <meta property="og:image:height" content="300" />
    <meta property="og:image:alt" content="Emala Fintech" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="author" content="Henock BARAKAEL | barahenock@gmail.com | +243828584688">
    <link rel="icon" href="{{ asset('backend/images/icon1.png')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{ asset('backend/images/icon1.png')}}" type="image/x-icon">
    <title>Wallet Historique</title>
    <link href="{{ asset('dist/css?family=Rubik:400,400i,500,500i,700,700i&amp;display=swap')}}" rel="stylesheet">
    <link href="{{ asset('dist/css-1?family=Roboto:300,300i,400,400i,500,500i,700,700i,900&amp;display=swap')}}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/font-awesome.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/icofont.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/themify.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/flag-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/feather-icon.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/sweetalert2.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/scrollbar.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/date-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/datatables.css')}}">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
    <link
      href="https://code.jquery.com/ui/1.12.1/themes/ui-lightness/jquery-ui.css" rel="stylesheet"/>
    <style>.myshadow{
      box-shadow: 0 10px 5px -1px rgba(0,0,0,.2),0 15px 18px 0 rgba(0,0,0,.14),0 1px 14px 0 rgba(0,0,0,.12)!important;
      border-radius: 8px;
    }</style>
    
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/datatable-extension.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/daterange-picker.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/vendors/bootstrap.css')}}">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/style.css')}}">
    <link id="color" rel="stylesheet" href="{{ asset('backend/css/color-1.css')}}" media="screen">
    <link rel="stylesheet" type="text/css" href="{{ asset('backend/css/responsive.css')}}">
    <link rel="stylesheet" href="{{ asset('backend/css/toastr.min.css') }}">
    <script src="{{ asset('backend/js/toastr_jquery.min.js') }}"></script>
    <script src="{{ asset('backend/js/toastr.min.js') }}"></script>
</head>
@endpush
@section('content')
@section('page','Demande de recharge')
@section('page_1','Wallet')
@section('page_2','Demande de recharge')
{!! Toastr::message() !!}
  <div class="page-body">

    @include('sweetalert::alert')
    @include('layouts.page-title')

    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <!-- Flexible table width Starts-->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="display" id="basic-8">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Montant</th>
                      <th>Devise</th>
                      <th>Wallet</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($requests as $key => $value)
                    <tr>
                      <td class="id">{{++$key}}</td>
                      <td class="w_cdf">{{$value->amount}}</td>
                      <td class="w_usd">{{$value->currency}}</td>
                      <td class="w_type">{{$value->wallet_code}}</td>
                      <td class="w_type">{{$value->status}}</td>
                    </tr>
                  @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
        <!-- Flexible table width  Ends-->
    </div>

  </div>

@section('script')
<script src="{{ asset('backend/js/jquery-3.5.1.min.js')}}"></script>
<script src="{{ asset('backend/js/bootstrap/bootstrap.bundle.min.js')}}"></script>
<script src="{{ asset('backend/js/icons/feather-icon/feather.min.js')}}"></script>
<script src="{{ asset('backend/js/icons/feather-icon/feather-icon.js')}}"></script>
<script src="{{ asset('backend/js/scrollbar/simplebar.js')}}"></script>
<script src="{{ asset('backend/js/scrollbar/custom.js')}}"></script>
<script src="{{ asset('backend/js/config.js')}}"></script>
<script src="{{ asset('backend/js/sidebar-menu.js')}}"></script>
<script src="{{ asset('backend/js/datatable/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{ asset('backend/js/datatable/datatables/datatable.custom.js')}}"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="{{ asset('backend/js/script.js')}}"></script>

    <script>
        $(document).on('click','.recharge',function()
        {
            var _this = $(this).parents('tr');
            $('#e_w_code').val(_this.find('.w_code').text());
            $('#e_w_usd').val(_this.find('.w_usd').text());
            $('#e_w_cdf').val(_this.find('.w_cdf').text());
        });
        $(document).on('click','.userDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_ids').val(_this.find('.id').text());
        });
    </script>
    @endsection
@endsection