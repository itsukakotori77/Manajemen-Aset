<header>
    <!-- Header Start -->
    <div class="header-area header-transparrent ">
        <div class="main-header header-sticky">
            <div class="container">
                <div class="row align-items-center">
                    <!-- Logo -->
                    <div class="col-xl-2 col-lg-2 col-md-1">
                        <div class="logo">
                            <a href="{{ url('/komplen') }}"><img src="{{ asset('assets-front/img/logo/logo.png') }}" alt="" style="width: 50px;"></a>
                        </div>
                    </div>
                    <div class="col-xl-8 col-lg-8 col-md-8">
                        <!-- Main-menu -->
                        <div class="main-menu f-right d-none d-lg-block">
                            <nav> 
                                <ul id="navigation">    
                                    <li><a href="{{ url('/komplen') }}">Home</a></li>
                                    <!-- <li><a href="#">Daftar Aset</a>
                                        <ul class="submenu">
                                            <li><a href="{{ url('/pengaduan/aset/data/tersedia') }}">Aset Tersedia</a></li>
                                            <li><a href="{{ url('/pengaduan/aset/data/habis') }}">Aset Habis Pakai</a></li>
                                            <li><a href="{{ url('/komplen/stock') }}">Cek Stok Aset</a></li>
                                        </ul>
                                    </li> -->
                                    <li><a href="{{ url('/') }}">Kembali</a>
                                </ul>
                            </nav>
                        </div>
                    </div>             
                    <div class="col-xl-2 col-lg-2 col-md-3">
                        <div class="header-right-btn f-right d-none d-lg-block">
                            <a href="{{ url('/pengaduan/aset') }}" class="btn header-btn">Pengaduan</a>
                        </div>
                    </div>
                    <!-- Mobile Menu -->
                    <div class="col-12">
                        <div class="mobile_menu d-block d-lg-none"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Header End -->
</header>