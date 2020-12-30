<!DOCTYPE html>
<html>
<head>
	<!-- Basic Page Info -->
	<meta charset="utf-8">
	<title>Sistem Manajemen Aset | SMKN 5 Bandung</title>

	<!-- Site favicon -->
	<link rel="apple-touch-icon" sizes="180x180" href="vendors/images/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="{{ asset('assets/vendors/images/smkn5.png') }}">

	<!-- Mobile Specific Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <meta content="{{ csrf_token() }}" name="csrf_token">
    
    <!-- Link css -->
    @include('layouts.linkcss')

    @section('css')
    @show

    <!-- Form-logout -->
    <form action="{{ url('/logout') }}" method="POST" id="form-logout">{{ csrf_field() }}</form>
</head>
<body>

	<!-- <div class="pre-loader">
		<div class="pre-loader-box">
			<div class="loader-logo"><img src="{{ asset('assets/vendors/images/loading.png') }}" alt="" style="width: 250px;"></div>
                <div class="loader-progress" id="progress_div">
                    <div class="bar" id="bar1"></div>
                </div>
			<div class="percent" id="percent1">0%</div>
                <div class="loading-text">
                    Loading...
                </div>
		</div>
	</div> -->

    <!-- Navbar -->
    @include('layouts.navbar')
    
    <!-- Sidebar -->
	@include('layouts.sidebar')

	<div class="main-container">
		<div class="pd-ltr-20">

            <!-- Content -->
            @yield('content')
			
            <!-- Footer -->
            @include('layouts.footer')
		</div>
    </div>
    <!-- Script -->
    @include('layouts.linkjs')

    <!-- Custom js -->
    @section('js')
    @show 
</body>
</html>