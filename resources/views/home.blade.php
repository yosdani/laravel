@extends('layouts.app')
@section('content')
    <div id="app">
        <app :user="{{json_encode(Auth::user())}}"></app>
    </div>
@endsection
