@extends('layouts.app')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tabel Pegawai</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tabel Pegawai</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-md-6">
                    
                </div>
            </div>
        </div>
        <!-- Simple Tabel Aset End -->
        <!-- multiple select row Datatable start -->
        <div class="card-box mb-30">
            <!-- Nav Link -->
            <div class="card-header">
                <ul class="nav nav-pills card-header-pills">
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('aset') }}" href="{{ url('/aset') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('aset/data/masuk') }}" href="{{ url('/aset/data/masuk') }}">Data Aset Masuk</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ setActive('aset/data/penetapan') }}" href="{{ url('/aset/data/penetapan') }}">Data Aset Penetapan</a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="row clearfix progress-box">
            <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial1" value="{{ $data['aset_tersedia'] }}" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#1b00ff" data-angleOffset="180" readonly>
                        <h5 class="text-blue padding-top-10 h5">Aset Tersedia</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 mb-30">
                <div class="card-box pd-30 height-100-p">
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial2" value="{{ $data['aset_ditempatkan'] }}" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#00e091" data-angleOffset="180" readonly>
                        <h5 class="text-light-green padding-top-10 h5">Aset Ditempatkan</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script src="{{ asset('assets/plugin/jQuery-Knob-master/jquery.knob.min.js') }}"></script>
    <script>
        $(".dial1").knob();
        $({animatedVal: 0}).animate({animatedVal: parseInt("{{ $data['aset_tersedia'] }}")}, {
            duration: 1000,
            easing: "swing",
            step: function() {
                $(".dial1").val(Math.ceil(this.animatedVal)).trigger("change");
            }
        });
        $(".dial2").knob();
        $({animatedVal: 0}).animate({animatedVal: parseInt("{{ $data['aset_ditempatkan'] }}")}, {
            duration: 1000,
            easing: "swing",
            step: function() {
                $(".dial2").val(Math.ceil(this.animatedVal)).trigger("change");
            }
        });

    </script>

@stop 