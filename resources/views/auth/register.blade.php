@extends('layouts.app')
@section('content')
<div class="row m-0">
    <div class="col-12 p-0">    
      <div class="login-card">
        <div>
          <div><a class="logo" href="index.html"><img class="img-fluid for-light" src="{{ asset('backend/images/logo/logo.png')}}" alt="looginpage"><img class="img-fluid for-dark" src="{{ asset('backend/images/logo/logo.png')}}" alt="looginpage"></a></div>
          <div class="login-main"> 
            <form class="theme-form" action="{{route('register')}}" method="POST">
            @csrf
              <h4>Créez votre compte</h4>
              <p>Entrez vos données personnelles pour créer un compte</p>
              <div class="form-group">
                <label class="col-form-label pt-0">Nom complet</label>
                <div class="row g-2">
                  <div class="col-6">
                    <input name="firstname" class="form-control @error('firstname') is-invalid @enderror" type="text" value="{{ old('firstname') }}" required="" placeholder="Prénom">
                    @error('firstname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                  <div class="col-6">
                    <input name="lastname" class="form-control @error('lastname') is-invalid @enderror" type="text" value="{{ old('lastname') }}" required="" placeholder="Nom">
                    @error('lastname')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-form-label">Adresse email</label>
                <input name="email" class="form-control @error('email') is-invalid @enderror" type="email" value="{{ old('email') }}" required="" placeholder="Test@gmail.com">
                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror       
              </div>
              <div class="form-group">
                <label class="col-form-label">Téléphone</label>
                <input name="phone_number" minlength="9" maxlength="12" class="form-control @error('phone_number') is-invalid @enderror" value="{{ old('phone_number') }}" type="text" required="" placeholder="243828584688">
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror    
              </div>
              <div class="form-group">
                <label class="col-form-label pt-0">Mot de passe</label>
                <div class="row g-2">
                  <div class="col-6">
                    <input name="password" minlength="5" maxlength="5" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" type="password" required="" placeholder="Mot de passe">
                    @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror    
                  </div>
                  <div class="col-6">
                    <input name="password_confirmation" minlength="5" maxlength="5" class="form-control" type="password" required="" placeholder="Confirmer mot de passe">
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label class="col-form-label" for="validationCustom04">Rôle</label>
                <select name="role" class="form-select" id="role" required="">
                  <option selected="" disabled="" value="">Choisir...</option>
                        <option value="Admin">Admin</option>
                        <option value="Manager">Manager</option>
                        <option value="Cashier">Cashier</option>
                </select>
                <div class="invalid-feedback">Please select a valid state.</div>
              </div>

              <div class="form-group mb-0">
                <div class="checkbox p-0">
                  <input id="checkbox1" type="checkbox">
                  <label class="text-muted" for="checkbox1">J'accepte <a class="ms-2" href="#">la politique de confidentialité</a></label>
                </div>
                <button class="btn btn-primary btn-block w-100" type="submit">Créer le compte</button>
              </div>

              <p class="mt-4 mb-0">Vous avez déjà un compte?<a class="ms-2" href="{{route('login')}}">Connectez-vous ici</a></p>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
