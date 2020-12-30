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
                            <li class="breadcrumb-item active" aria-current="page">Tabel {{ $data['title'] }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- multiple select row Datatable start -->
        <div class="card-box mb-30">
            <div class="pd-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Data {{ $data['title'] }}</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/ruangan') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                </div>
            </div>
            <div class="pb-20" style="margin-top: 30px;">
                <div class="container">
                    <!-- Kondisi -->
                    @if(session('message'))
                        <div class="alert alert-danger" role="alert">
                            <i class="fa fa-bell"></i>
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Form -->
                    <form action="{{ url('/ruangan/' . $data['ruangan']->ID_Ruangan . '/edit') }}" method="POST" autocomplete="off" id="formRuangan">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}
                        
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- Kode Ruangan -->
                                <div class="form-group">
                                    <label for="">Kode Ruangan <span style="color: #FF0000">*</span></label>
                                    <input type="text" required class="form-control" name="Kode_Ruangan" id="Kode_Ruangan" placeholder="Kode Ruangan" value="{{ $data['ruangan']->Kode_Ruangan }}">
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <!-- Nama Ruangan -->
                                <div class="form-group">
                                    <label for="">Nama Ruangan <span style="color: #FF0000">*</span></label>
                                    <input type="text" required class="form-control" name="Nama_Ruangan" id="Nama_Ruangan" placeholder="Nama Ruangan" value="{{ $data['ruangan']->Nama_Ruangan }}">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Jenis Ruangan -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Jenis Ruangan <span style="color: #FF0000">*</span></label>
                                    <select name="Jenis_Ruangan" style="width: 100%" id="Jenis_Ruangan" required class="form-control custom-select2">
                                        <option disabled selected="selected">-- Pilih --</option>
                                        <option value="1" @if($data['ruangan']->Jenis_Ruangan === 1) selected="selected" @endif>Ruang Kelas</option>
                                        <option value="2" @if($data['ruangan']->Jenis_Ruangan === 2) selected="selected" @endif>Ruang Praktek</option>
                                    </select>
                                </div>
                            </div>
                            <!-- Jurusan -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Jurusan <span style="color: #FF0000">*</span></label>
                                    <select name="Jurusan_ID" style="width: 100%" id="Jurusan" required class="form-control custom-select2">
                                        <option disabled selected="selected">-- Pilih --</option>
                                        @foreach($data['jurusan'] as $jurusan)
                                        <option value="{{ $jurusan->Kode_Jurusan }}" @if($data['ruangan']->Jurusan_ID === $jurusan->Kode_Jurusan) selected="selected" @endif\>{{ $jurusan->Nama_Jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- button -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pull-right">
                                    <button type="reset" class="btn btn-danger btn-sm">RESET RUANGAN</button>
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
        // Jquery Validator
        $("#formRuangan").validate({
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