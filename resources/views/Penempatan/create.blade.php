@extends('layouts.app')

@section('css')

    <style>
        .without-border{
             border: none;
        }
    </style>

@stop 

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
                    <h4 class="text-blue h4">{{ 'Penempatan Aset' . ' ' . $data['aset']->Nama_Aset }}</h4>
                </div>
                @if(Request::is('/penempatan/create'))
                    <div class="pull-right">
                        <a href="{{ url('/penempatan') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                    </div>
                @else
                    <div class="pull-right">
                        <a href="{{ url('/aset/data/masuk') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                    </div>
                @endif
            </div>
            <div class="pb-20" style="margin-top: 30px;">
                <div class="container">

                    <!-- Penempatan Otomatis -->
                    @if(isset($data['aset']))
                        <!-- Form -->
                        <form action="{{ url('/penempatan') }}" method="POST" autocomplete="off" id="formPenempatan">
                            {{ csrf_field() }}

                            <!-- Hidden -->
                            <input type="hidden" name="Aset_Otomatis" id="Aset" value="{{ $data['aset_penempatan']->Aset_ID }}">
                            <input type="hidden" name="Ruangan" id="Aset" value="{{ $data['aset_penempatan']->Ruangan_ID }}">
                            <input type="hidden" name="Jumlah" id="Aset" value="{{ $data['aset_penempatan']->Jumlah_Aset }}">

                            <!-- Penempatan -->
                            <div class="row">
                                <!-- Ruangan -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Ruangan</label>
                                        <select class="form-control custom-select2" name="Ruangan_Otomatis" id="Ruangan" style="width: 100%" disabled>
                                            <option disabled selected="selected">-- Pilih --</option>
                                            @foreach($data['ruangan'] as $ruangan)
                                                <option value="{{ $ruangan->ID_Ruangan }}" @if($data['aset_penempatan']->Ruangan_ID === $ruangan->ID_Ruangan) selected="selected" @endif>{{ $ruangan->Nama_Ruangan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Jumlah -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Jumlah</label>
                                        <input type="text" name="Jumlah_Otomatis" id="Jumlah" class="form-control" value="{{ $data['aset_penempatan']->Jumlah_Aset }}" disabled>
                                    </div>
                                </div>

                                <!-- Tanggal Penempatan -->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="">Tanggal Penempatan <span style="color: #FF0000;">*</span></label>
                                        <input type="text" class="form-control date-picker" id="Tanggal_Penempatan" name="Tanggal_Penempatan" placeholder="Tanggal Penempatan dd/mm/YYYY">
                                    </div>
                                </div>

                            </div>
                            <!-- button -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <button type="reset" class="btn btn-danger btn-sm">RESET PENEMPATAN</button>
                                        <button type="submit" class="btn btn-success btn-sm">SIMPAN</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    <!-- Penempatan Manual -->
                    @else
                        <!-- Form -->
                        <form action="{{ url('/penempatan') }}" method="POST" autocomplete="off" id="formPenempatan">
                            {{ csrf_field() }}

                            <!-- Penempatan -->
                            <div class="row">
                                <!-- Ruangan -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="">Ruangan</label>
                                        <select class="form-control custom-select2" name="Ruangan" id="Ruangan" style="width: 100%">
                                            <option disabled selected="selected">-- Pilih --</option>
                                            @foreach($data['ruangan'] as $ruangan)
                                                <option value="{{ $ruangan->ID_Ruangan }}">{{ $ruangan->Nama_Ruangan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Aset -->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        @if($data['aset'])
                                            <label for="">Daftar Aset</label>
                                            @foreach($data['aset'] as $aset)
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <div class="custom-control custom-checkbox mb-5">
                                                            <input type="checkbox" name="Aset[]" class="custom-control-input" id="Aset{{ $loop->iteration }}" value="{{ $aset->Kode_Aset }}">
                                                            <label class="custom-control-label" for="Aset{{ $loop->iteration }}">{{ $aset->Nama_Aset }}</label>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <input type="number" min="1" class="form-control without-border" name="Jumlah[]" id="Jumlah" placeholder="Jumlah">
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <span>Data aset tidak tersedia</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- button -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="pull-right">
                                        <button type="reset" class="btn btn-danger btn-sm">RESET PENEMPATAN</button>
                                        <button type="submit" class="btn btn-success btn-sm">SIMPAN</button>
                                    </div>
                                </div>
                            </div>
                        
                        </form>
                    @endif 
                   
                </div>
            </div>
        </div>
    </div>

@endsection 

@section('js')

    <script>
        // Datepicker
        $('.date-picker').datepicker({
            language: 'en',
            autoClose: true,
            dateFormat: 'dd MM yyyy',
            minDate: new Date()
        });
    </script>

@stop 
