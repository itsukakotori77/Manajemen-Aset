<!doctype html>
<html class="no-js" lang="zxx">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <title>Sistem Manajemen Aset | SMKN 5 Bandung</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="manifest" href="site.webmanifest">
        <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/vendors/images/smkn5.png') }}">
        <!-- CSS here -->

        @include('layouts-front.linkcss')

        @section('css')
        @show

   </head>
   <body>
       
    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="preloader-circle"></div>
                <div class="preloader-img pere-text">
                    <img src="{{ asset('assets-front/img/logo/logo.png') }}" alt="">
                </div>
            </div>
        </div>
    </div>
    <!-- Preloader Start -->

    <!-- Form -->
    <form action="{{ url('/logout') }}" id="form-logout" method="POST">{{ csrf_field() }}</form>

    @include('layouts-front.header')

    <main>
        
        @yield('content')

    </main>

    @include('layouts-front.footer')
   
    <!-- JS here -->
    @include('layouts-front.linkjs')

    @section('js')

    @show

    </body>
</html>