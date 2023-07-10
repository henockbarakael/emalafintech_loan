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
    <title>Emala - Taux annuel</title>
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
@section('page','Taux annuel')
@section('page_1','Prêt')
@section('page_2','Taux annuel')
{!! Toastr::message() !!}
  <div class="page-body">

    @include('sweetalert::alert')
    @include('layouts.page-title')
    
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        {{-- <div class="row mt-2 mb-4">
            <div style="height: 30px">
              <a href="#" class="btn btn-success btn-sm pull-right"  title="Ajouter un taux" data-bs-toggle="modal" data-original-title="test" data-bs-target="#add_user"><span><i class="fa fa-plus text-white"></i></span> Ajouter un taux</a>
            </div>
        </div> --}}
        <!-- Flexible table width Starts-->
        <div class="col-sm-12">
          <div class="card">
            <div class="card-body">
              <div class="table-responsive">
                <table class="display" id="basic-8">
                  <thead>
                    <tr>
                      <th hidden>ID</th>
                      {{-- <th>Nombre de mois</th> --}}
                      <th>Taux annuel (%)</th>
                      {{-- <th>Intérêt</th> --}}
                      {{-- <th>Pénalité %</th> --}}
                      <th class="text-center">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                  @foreach ($prets as $key => $value)
                    <tr>
                      <td hidden class="id">{{$value->id}}</td>
                      {{-- <td class="months">{{$value->months}}</td> --}}
                      <td class="rate">{{$value->rate}}</td>
                      {{-- <td class="interest_percentage">{{$value->interest_percentage}}</td> --}}
                      {{-- <td class="penalty_rate">{{$value->penalty_rate}}</td> --}}
                      <td class="text-center">
                        <a href="" class="btn btn-success btn-xs userUpdate" title="Edit admin" data-bs-toggle="modal" data-original-title="test" data-bs-target="#edit_user"><i class="fa fa-edit"></i></a>
                        <a href="" class="btn btn-danger btn-xs userDelete" title="Delete admin" data-bs-toggle="modal" data-original-title="test" data-bs-target="#delete_user"><i class="icofont icofont-ui-delete"></i></a>
                      </td>
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

      {{-- <div class="modal fade" id="add_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Plan de prêt</h5>
            </div>
            <div class="modal-body">
                <form class="needs-validation" action="{{route('admin.pret.plan.post')}}" novalidate=""method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label" for="months">Plan(mois)</label>
                            <input oninput="add_number2()" class="form-control input-air-primary @error('months') is-invalid @enderror" name="months" id="months"  type="number" value="{{ old('months') }}" >
                            @error('months')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                        <div class="col-md-4">
                          <label class="form-label" for="rate">Taux %</label>
                          <input oninput="add_number2()" class="form-control input-air-primary @error('rate') is-invalid @enderror" id="rate" name="rate"  type="number" value="" >
                          @error('rate')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                        <div class="col-md-4">
                            <label class="form-label" for="interest_percentage">Intérêt</label>
                            <input class="form-control input-air-primary @error('interest_percentage') is-invalid @enderror" name="interest_percentage" id="interest_percentage"  type="number" value="" >
                            @error('interest_percentage')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="valid-feedback">Looks good!</div>
                        </div>
                  
                    </div>
                    <div class="modal-footer mt-5">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Valider</button>
                      </div>
                  </form>
              </div>
              
          </div>
        </div>
      </div> --}}
    
      <div class="modal fade" id="edit_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel2">Modifier Taux</h5>
            </div>
            <div class="modal-body">
                <form action="{{route('admin.pret.plan.edit')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="e_id" value="">
                    <div class="row g-3">
                      {{-- <div class="col-md-4">
                          <label class="form-label" for="months">Plan(mois)</label>
                          <input oninput="add_number()" class="form-control input-air-primary @error('months') is-invalid @enderror" name="months" id="e_months"   type="number" value="{{ old('months') }}" >
                          @error('months')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                          <div class="valid-feedback">Looks good!</div>
                      </div> --}}
                      <div class="col-md-12">
                          <label class="form-label" for="rate">Taux annuel %</label>
                          <input class="form-control input-air-primary @error('rate') is-invalid @enderror" id="e_rate" name="rate"  type="number" value="" >
                          {{-- <input oninput="add_number()" class="form-control input-air-primary @error('rate') is-invalid @enderror" id="e_rate" name="rate"  type="number" value="" > --}}
                          @error('rate')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                          <div class="valid-feedback">Looks good!</div>
                      </div>
                      {{-- <div class="col-md-4">
                        <label class="form-label" for="interest_percentage">Intérêt</label>
                        <input  readonly class="form-control input-air-primary @error('interest_percentage') is-invalid @enderror" id="e_interest_percentage" name="interest_percentage"  type="number" value="" >
                        @error('interest_percentage')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                        <div class="valid-feedback">Looks good!</div>
                      </div> --}}
                      {{-- <div class="col-md-4">
                          <label class="form-label" for="penalty_rate">Pénalité %</label>
                          <input class="form-control input-air-primary @error('penalty_rate') is-invalid @enderror" id="e_penalty_rate" name="penalty_rate"  type="number" value="{{ old('penalty_rate') }}" >
                          @error('penalty_rate')
                              <span class="invalid-feedback" role="alert">
                                  <strong>{{ $message }}</strong>
                              </span>
                          @enderror
                          <div class="valid-feedback">Looks good!</div>
                      </div> --}}
                
                  </div>
                    <div class="modal-footer mt-5">
                        <button class="btn btn-secondary" type="button" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary" type="submit">Modifier</button>
                      </div>
                  </form>
              </div>
              
          </div>
        </div>
      </div>
    
      <div class="modal fade" id="delete_user" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-body">
                <div class="text-center mt-4">
                    <h3>Supprimer le taux</h3>
                    <p>Etes-vous sûre de vouloir supprimer?</p>
                </div>
            </div>
            <div class="modal-btn">
                <form action="{{route('admin.pret.plan.delete')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" class="e_ids" value="">
                    <div class="row">
                        <div class="modal-footer justify-content-center" style="border-top: 0px; margin-top:-10px">
                            <button class="btn btn-primary" type="button" data-bs-dismiss="modal">Annuler</button>
                            <button class="btn btn-secondary" type="submit">Supprimer</button>
                          </div>
                    </div>
                </form>
            </div>
          </div>
        </div>
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

{{-- <script type="text/javascript">
  var rate = document.getElementById("e_rate");
  var plan = document.getElementById('e_months');

  function add_number() {

      var taux = parseFloat(rate.value/100);
      var duree = parseFloat(plan.value);
      var interet = (taux*duree)/12;
      if (isNaN(interet)) interet = 0;
      document.getElementById("e_interest_percentage").value = interet;

  }
</script>
<script type="text/javascript">
  var rate2 = document.getElementById("rate");
  var plan2 = document.getElementById('months');

  function add_number2() {

      var taux2 = parseFloat(rate2.value/100);
      var duree2 = parseFloat(plan2.value);
      var interet2 = (taux2*duree2)/12;
      if (isNaN(interet2)) interet2 = 0;
      document.getElementById("interest_percentage").value = interet2;

  }
</script> --}}
    <script>
        $(document).on('click','.userUpdate',function()
        {
            var _this = $(this).parents('tr');
            $('#e_id').val(_this.find('.id').text());
            $('#e_rate').val(_this.find('.rate').text());
            // $('#e_interest_percentage').val(_this.find('.interest_percentage').text());
            // $('#e_months').val(_this.find('.months').text());
        });
        $(document).on('click','.userDelete',function()
        {
            var _this = $(this).parents('tr');
            $('.e_ids').val(_this.find('.id').text());
        });
    </script>
    @endsection
@endsection