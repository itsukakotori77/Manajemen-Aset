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
                    <form action="{{ url('/pengajuan/' . $data['pengajuan']->Kode_Pengajuan . '/edit') }}" method="POST" autocomplete="off" id="formPengajuan">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <!-- Input -->
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Nama Pengajuan -->
                                <div class="form-group">
                                    <label for="">Nama Pengajuan</label>
                                    <input type="text" class="form-control" name="Nama_Pengajuan" id="Nama_Pengajuan" placeholder="Nama Pengajuan" value="{{ $data['pengajuan']->Nama_Pengajuan }}">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Tanggal Pengajuan -->
                                <div class="form-group">
                                    <label for="">Tanggal Pengajuan</label>
                                    <input type="text" class="form-control date-picker" name="Tanggal_Pengajuan" id="Tanggal_Pengajuan" placeholder="Tanggal Pengajuan" value="{{ date('d F Y', strtotime($data['pengajuan']->Tanggal_Pengajuan)) }}">
                                </div>
                            </div>
                        </div>

                        <!-- Jurusan -->
                        <div class="form-group">
                            <label for="">Jurusan</label>
                            <select name="Jurusan" id="Jurusan" class="form-control">
                                <option selected="selected" disabled>-- Pilih Jurusan --</option>
                                @foreach($data['jurusan'] as $jurusan)
                                    <option value="{{ $jurusan->Kode_Jurusan }}" selected="@if($data['pengajuan']->Jurusan_ID === $jurusan->Kode_Jurusan) selected @endif">{{ $jurusan->Nama_Jurusan }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Input Perencanaan -->
                        <div class="form-group">
                            <label class="weight-600">Pengajuan minggu ini</label>
                            @foreach($data['perencanaan'] as $perencanaan)
                                <div class="custom-control custom-checkbox mb-5">
                                    <input type="checkbox" name="Perencanaan[]" disabled required class="custom-control-input" id="Perencanaan{{ $loop->iteration }}" value="{{ $perencanaan->Kode_Perencanaan }}">
                                    <label class="custom-control-label" for="Perencanaan{{ $loop->iteration }}">{{ $perencanaan->Nama_Perencanaan }}</label>
                                </div>
                            @endforeach
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
        // $(function(){
        //     // Datepicker
        //     $('.date-picker').datepicker({
        //         language: 'en',
        //         autoClose: true,
        //         dateFormat: 'dd MM yyyy',
        //         minDate: new Date()
        //     });
        // })

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