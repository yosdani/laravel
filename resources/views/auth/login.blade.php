@extends('layouts.app')
@php
$bodyClass = 'login-body';
@endphp
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="text-center login-image" >
                <img class="image-rounded" src="{{ asset('images/logo-2.png') }}" width="25%">
            </div>
            <div class="card mt-5 login-card">
                <div class="card-body">

                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="col-md-10 offset-md-1 mt-5">
                            <div class="form-group row">
                                <label for="email" class="col-md-12 col-form-label">{{ __('Email') }}</label>

                                <div class="col-md-12">
                                    <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                                    @if ($errors->has('email'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="password" class="col-md-12 col-form-label">{{ __('Contraseña') }}</label>

                                <div class="col-md-12">
                                    <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row mb-0">
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Entrar') }}
                                    </button>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link text-white-50" href="{{ route('password.request') }}">
                                            {{ __('Olvidó la contraseña?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </form>
                </div>
            </div>




        </div>
    </div>
</div>
@endsection

