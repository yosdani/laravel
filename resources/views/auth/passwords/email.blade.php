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
                    <div class="col-12">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                    </div>


                    <form method="POST" class="mt-3" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row col-md-10 offset-md-1">
                            <label for="email" class="col-md-12 col-form-label">{{ __('auth.email') }}</label>

                            <div class="col-md-12">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0 col-md-10 offset-md-1">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary mb-3">
                                    {{ __('general.send') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
