<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ url('/dashboard') }}">
            <img src="{{ asset('assets/vendors/images/logo-white.png') }}" alt="" class="light-logo">
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li class="dropdown">
                    <a href="{{ url('/dashboard') }}" class="dropdown-toggle no-arrow {{ setActive(['dashboard*']) }}">
                        <span class="micon dw dw-house-1"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>

                @if(Auth::user()->role_id === 1) <!-- Admin -->
                    <!-- Modul 1 -->
                        <!-- Pegawai -->
                        <li>
                            <a href="{{ url('/pegawai') }}" class="dropdown-toggle no-arrow {{ setActive(['pegawai*']) }}">
                                <span class="micon dw dw-user-2"></span><span class="mtext">Pegawai</span>
                            </a>
                        </li>
                    <!-- End of Modul 1 -->

                    <!-- Modul 2 -->
                        <!-- Aset -->
                        <li>
                            <a href="{{ url('/aset') }}" class="dropdown-toggle no-arrow {{ setActive(['aset*']) }}">
                                <span class="micon dw dw-book1"></span><span class="mtext">Aset</span>
                            </a>
                        </li>
                    <!-- End Modul 2 -->

                @elseif(Auth::user()->role_id === 2) <!-- Ketua Kompetensi -->
                    <!-- Modul 3 -->
                        <!-- Perencanaan -->
                        <li>
                            <a href="{{ url('/perencanaan') }}" class="dropdown-toggle no-arrow {{ setActive(['perencanaan*']) }}">
                                <span class="micon dw dw-file-154"></span><span class="mtext">Perencanaan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/pengajuan') }}" class="dropdown-toggle no-arrow {{ setActive(['pengajuan*']) }}">
                                <span class="micon dw dw-clipboard1"></span><span class="mtext">Pengajuan</span>
                            </a>
                        </li>
                    <!-- End of Modul 3 -->
                    <!-- Modul 8 -->
                        <li>
                            <a href="{{ url('/laporan/perencanaan') }}" class="dropdown-toggle no-arrow {{ setActive(['laporan/perencanaan']) }}">
                                <span class="micon dw dw-clipboard1"></span><span class="mtext">Laporan Perencanaan</span>
                            </a>
                        </li>
                    <!-- End of Modul 8 -->
                @elseif(Auth::user()->role_id === 3) <!-- Ketua Sarpas -->
                    <!-- Modul 8 -->
                        <li class="dropdown {{ setShow(['laporan*']) }}">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon icon-copy dw dw-book"></span><span class="mtext">Laporan</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="{{ setActive(['laporan/pengaduan']) }}" href="{{ url('/laporan/pengaduan') }}">Laporan Pengaduan</a></li>
                                <li><a class="{{ setActive(['laporan/pengajuan']) }}" href="{{ url('/laporan/pengajuan') }}">Laporan Pengajuan</a></li>
                                <li><a class="{{ setActive(['laporan/aset']) }}" href="{{ url('/laporan/aset') }}">Laporan Aset Masuk</a></li>
                            </ul>
                        </li>
                    <!-- End of Modul 8 -->
                @elseif(Auth::user()->role_id === 5) <!--TU Sarpras -->
                    <!-- Modul 2 -->
                        <!-- Aset -->
                        <li>
                            <a href="{{ url('/aset') }}" class="dropdown-toggle no-arrow {{ setActive(['aset*']) }}">
                                <span class="micon dw dw-book1"></span><span class="mtext">Aset</span>
                            </a>
                        </li>
                    <!-- End Modul 2 -->

                    <!-- Modul 5 -->
                        <!-- Ruangan -->
                        <li>
                            <a href="{{ url('/pengaduan') }}" class="dropdown-toggle no-arrow {{ setActive(['pengaduan*']) }}">
                                <span class="micon icon-copy dw dw-map-4"></span><span class="mtext">Pengaduan</span>
                            </a>
                        </li>
                        <!-- End of modul 5 -->
                        <!-- Ruangan -->
                        <li>
                            <a href="{{ url('/ruangan') }}" class="dropdown-toggle no-arrow {{ setActive(['ruangan*']) }}">
                                <span class="micon icon-copy dw dw-apartment"></span><span class="mtext">Ruangan</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ url('/penempatan') }}" class="dropdown-toggle no-arrow {{ setActive(['penempatan*']) }}">
                                <span class="micon icon-copy dw dw-factory"></span><span class="mtext">Penempatan</span>
                            </a>
                        </li>
                        <!-- Modul 3 -->
                        <li>
                            <a href="{{ url('/pengajuan') }}" class="dropdown-toggle no-arrow {{ setActive(['pengajuan*']) }}">
                                <span class="micon dw dw-clipboard1"></span><span class="mtext">Pengajuan</span>
                            </a>
                        </li>
                    <!-- End of Modul 3 -->

                    <!-- Modul 6 -->
                        <li>
                            <a href="{{ url('/pemeliharaan') }}" class="dropdown-toggle no-arrow {{ setActive(['pemeliharaan*']) }}">
                                <span class="micon icon-copy dw dw-reload"></span><span class="mtext">Pemeliharaan</span>
                            </a>
                        </li>
                        
                    <!-- End of modul -->             
                    
                    <!-- Modul 7 -->
                        <li>
                            <a href="{{ url('/penghapusan') }}" class="dropdown-toggle no-arrow {{ setActive(['penghapusan*']) }}">
                                <span class="micon icon-copy dw dw-delete-3"></span><span class="mtext">Penghapusan</span>
                            </a>
                        </li>

                    <!-- End of modul 7 -->

                    <!-- Modul 8 -->
                        <li class="dropdown {{ setShow(['laporan*']) }}">
                            <a href="javascript:;" class="dropdown-toggle">
                                <span class="micon icon-copy dw dw-book"></span><span class="mtext">Laporan</span>
                            </a>
                            <ul class="submenu">
                                <li><a class="{{ setActive(['laporan/pengaduan']) }}" href="{{ url('/laporan/pengaduan') }}">Laporan Pengaduan</a></li>
                                <li><a class="{{ setActive(['laporan/pengajuan']) }}" href="{{ url('/laporan/pengajuan') }}">Laporan Pengajuan</a></li>
                                <li><a class="{{ setActive(['laporan/aset']) }}" href="{{ url('/laporan/aset') }}">Laporan Aset Masuk</a></li>
                            </ul>
                        </li>
                    <!-- End of Modul 8 -->
                @elseif(Auth::user()->role_id === 6) <!-- Guru -->
                    <!-- Perencanaan -->
                    <li>
                        <a href="{{ url('/perencanaan') }}" class="dropdown-toggle no-arrow {{ setActive(['perencanaan*']) }}">
                            <span class="micon dw dw-file-154"></span><span class="mtext">Perencanaan</span>
                        </a>
                    </li>
                @endif 
                
            </ul>
        </div>
    </div>
</div>
<div class="mobile-menu-overlay"></div>