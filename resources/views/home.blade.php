@extends('layouts.app')
@section('content')
    <div id="app">
        <?php \Log::info(Auth::user()); ?>
        <app userAuth="{{ Auth::user() }}"></app>
    </div>
@endsection
