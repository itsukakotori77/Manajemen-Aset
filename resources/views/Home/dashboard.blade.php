@extends('layouts.app')

@section('content')

    <div class="card-box pd-20 height-100-p mb-30">
        <div class="row align-items-center">
            <div class="col-md-4">
                <img src="{{ asset('assets/vendors/images/banner-img.png') }}" alt="">
            </div>
            <div class="col-md-8">
                <h4 class="font-20 weight-500 mb-10 text-capitalize">
                    Selamat datang kembali <div class="weight-600 font-30 text-blue">{{ Auth::user()->username }}!</div>
                </h4>
            </div>
        </div>
    </div>

    @if(Auth::user()->role_id === 1 || Auth::user()->role_id === 5)
        <!-- Badge -->
        <div class="row">
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart"></div>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">{{ $data['aset_berwujud'] }}</div>
                            <div class="weight-600 font-14">Aset berwujud</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart2"></div>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">{{ $data['aset_habis_pakai'] }}</div>
                            <div class="weight-600 font-14">Aset habis pakai</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart3"></div>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">{{ $data['pengajuan'] }}</div>
                            <div class="weight-600 font-14">Pengajuan</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 mb-30">
                <div class="card-box height-100-p widget-style1">
                    <div class="d-flex flex-wrap align-items-center">
                        <div class="progress-data">
                            <div id="chart4"></div>
                        </div>
                        <div class="widget-data">
                            <div class="h4 mb-0">{{ $data['aset'] }}</div>
                            <div class="weight-600 font-14">Aset</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12 mb-30">
                <div class="card-box height-100-p pd-20">
                    <h2 class="h4 mb-20">Total pengajuan</h2>
                    <div id="chart5"></div>
                </div>
            </div>
        </div>

        <!-- Table -->
        <div class="card-box mb-30">
            <h2 class="h4 pd-20">Aset paling banyak digunakan</h2>
            <div class="container">
                <table class="data-table table nowrap">
                    <thead>
                        <tr>
                            <th class="table-plus datatable-nosort">#</th>
                            <th>Nama Aset</th>
                            <th>Ruangan</th>
                            <th>Jenis Aset</th>
                            <th>Jumlah</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($data['penempatan'] as $penempatan)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $penempatan->Nama_Aset }}</td>
                                <td>{{ $penempatan->Kode_Ruangan . ' ' . $penempatan->Nama_Ruangan }}</td>
                                @if($penempatan->Jenis_Aset === 1)
                                    <td>Aset Berwujud</td>
                                @else 
                                    <td>Aset Tidak Berwujud</td>
                                @endif
                                <td>{{ $penempatan->Jumlah }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif 

@endsection 

@section('js')

    <script>
        data_diterima = [
            @foreach($data['jumlah_diterima'] as $data_diterima)
                {{ $data_diterima }},
            @endforeach
        ];

        data_ditolak = [
            @foreach($data['jumlah_ditolak'] as $data_ditolak)
                {{ $data_ditolak }},
            @endforeach
        ];

        data = [
            parseInt("{{ $data['aset_berwujud'] }}"),
            parseInt("{{ $data['aset_habis_pakai'] }}"),
            parseInt("{{ $data['pengajuan'] }}"),
            parseInt("{{ $data['aset'] }}"),
        ];

    </script>
    <script src="{{ asset('assets/plugin/apexcharts/apexcharts.min.js') }}"></script>        
    <script src="{{ asset('assets/vendors/scripts/dashboard.js') }}"></script>

@stop 