@extends('layouts.app')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>{{ $data['title'] }}</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                        </ol>
                    </nav>
                </div>
                <div class="col-sm-6">
                    <div class="pull-right">
                        <a href="{{ url('/penempatan') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mb-30">
            <div class="row">
                <div class="col-sm-8">
                    <div class="pd-20 card-box">
                        <div class="card-header">
                            <h4 class="text-blue">{{ $data['penempatan']->Kode_Ruangan . ' - ' . $data['penempatan']->Nama_Ruangan }}</h4>
                        </div>
                        <div class="card-body">
                            <h4 class="h4 text-blue">Karakteristik</h4>
                            <div id="chart1"></div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="pd-20 card-box height-100-p">
                        <h4 class="mb-20 h4">Daftar Aset</h4>
                        <ul class="list-group">
                            @foreach($data['aset'] as $aset)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    {{ $aset->Nama_Aset }}
                                    <span class="badge badge-primary badge-pill">{{ $aset->Jumlah }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

@endsection 

@section('js')

    <script src="{{ asset('assets/plugin/apexcharts/apexcharts.min.js') }}"></script>
    <script>

        data = [
            @foreach($data['data_aset'] as $data_aset)
                {{ $data_aset }},
            @endforeach
        ];

    </script>
    <script src="{{ asset('assets/vendors/scripts/apexcharts-setting.js') }}"></script>

@stop 
