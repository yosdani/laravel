<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }}</title>

    <script src="{{ asset('js/app.js') }}" defer></script>

    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/favicon.png') }}">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>
<body>
    <div id="app-container" class="{{ $bodyClass ?? '' }}">
        <main class="">
            @yield('content')
        </main>
    </div>
    <script>
        // Loading
        var Loading=(loadingDelayHidden=0)=>{let loading=null;const myLoadingDelayHidden=loadingDelayHidden;let imgs=[];let lenImgs=0;let counterImgsLoading=0;function incrementCounterImgs(){counterImgsLoading+=1;if(counterImgsLoading===lenImgs){hideLoading()}}function hideLoading(){if(loading!==null){loading.classList.remove('show');setTimeout(function(){loading.remove()},myLoadingDelayHidden)}}function init(){document.addEventListener('DOMContentLoaded',function(){loading=document.querySelector('.loading');imgs=Array.from(document.images);lenImgs=imgs.length;if(imgs.length===0){hideLoading()}else{imgs.forEach(function(img){img.addEventListener('load',incrementCounterImgs,false)})}})}return{'init':init}}

        Loading(1000).init();
    </script>
</body>
</html>
