@extends('layouts.app')
@section('content')
    <div id="app"> 
        <panel-control :user="{{ json_encode(Auth::user())}}"></panel-control>
    </div>
@endsection
