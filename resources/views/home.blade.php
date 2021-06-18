@extends('layouts.app')
@section('content')
    <div id="app">
        <app userAuth="{{ Auth::user() }}"></app>
    </div>
@endsection
