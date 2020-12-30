@extends('layouts.app')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Form {{ $data['title'] }}</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Form {{ $data['title'] }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- multiple select row Datatable start -->
        <div class="card-box mb-30">
            <div class="pd-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Form {{ $data['title'] }}</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/pengajuan') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                </div>
            </div>
            <div class="pb-20" style="margin-top: 30px;">
                <div class="container">

                    <!-- Form -->
                    <form action="{{ url('/pengajuan') }}" method="POST" autocomplete="off" id="formPengajuan">
                        {{ csrf_field() }}

                        <!-- Input Hidden -->
                        <input type="hidden" name="Jurusan" value="{{ $data['jurusan']->Jurusan_ID }}">

                        <!-- Input -->
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Nama Pengajuan -->
                                <div class="form-group">
                                    <label for="">Nama Pengajuan <span style="color: #FF0000;">*</span></label>
                                    <input type="text" class="form-control" name="Nama_Pengajuan" required id="Nama_Pengajuan" placeholder="Nama Pengajuan">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Tanggal Pengajuan -->
                                <div class="form-group">
                                    <label for="">Tanggal Pengajuan <span style="color: #FF0000;">*</span></label>
                                    <input type="text" class="form-control date-picker" name="Tanggal_Pengajuan" required id="Tanggal_Pengajuan" placeholder="Tanggal Pengajuan">
                                </div>
                            </div>
                        </div>

                       

                        <!-- Input Perencanaan -->
                        <div class="form-group">
                            <label class="weight-600">Pengajuan minggu ini <span style="color: #FF0000;">*</span></label>
                            @if(count($data['perencanaan']) > 0)
                                @foreach($data['perencanaan'] as $perencanaan)
                                    <div class="custom-control custom-checkbox mb-5">
                                        <input type="checkbox" name="Perencanaan[]" required class="custom-control-input" id="Perencanaan{{ $loop->iteration }}" value="{{ $perencanaan->Kode_Perencanaan }}">
                                        <label class="custom-control-label" for="Perencanaan{{ $loop->iteration }}">{{ $perencanaan->Nama_Perencanaan }}</label>
                                    </div>
                                @endforeach
                            @else 
                                <h5 style="color: #FF0000;">Tidak ada perencanaan aset</h5>
                            @endif
                        </div>

                        <!-- button -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pull-right">
                                    <button type="reset" class="btn btn-danger btn-sm">RESET PENGAJUAN</button>
                                    <button type="submit" class="btn btn-success btn-sm">SIMPAN</button>
                                </div>
                            </div>
                        </div>
                    
                    </form>
                   
                </div>
            </div>
        </div>
    </div>

@endsection 

@section('js')

    <script>
        $(function(){
            // Datepicker
            $('.date-picker').datepicker({
                language: 'en',
                autoClose: true,
                dateFormat: 'dd MM yyyy',
                minDate: new Date()
            });
        })

        // Jquery Validator
        $("#formPengajuan").validate({
            // Rules
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('form-control-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                // Add Class
                $('.form-group').addClass('has-danger');
            }
        });
    </script>

@stop 