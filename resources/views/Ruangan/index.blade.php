@extends('layouts.app')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tabel {{ $title }}</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tabel {{ $title }}</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- multiple select row Datatable start -->
        <div class="card-box mb-30">
            <div class="pd-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Data {{ $title }}</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/ruangan/create') }}" class="btn btn-primary btn-sm"><i class="icon-copy fa fa-plus" aria-hidden="true"></i> <strong>TAMBAH</strong></a>
                </div>
            </div>
            <div class="pb-20" style="margin-top: 30px;">
                <div class="container">
                    <!-- Kondisi -->
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-bell"></i>
                            {{ session('message') }}
                        </div>
                    @endif

                    <!-- Table -->
                    <table class="data-table table datatable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Ruangan</th>
                                <th>Nama Ruangan</th>
                                <th>Jenis Ruangan</th>
                                <th>Jurusan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection 

@section('js')

    <script>
        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url('/ruangan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'Kode_Ruangan', name: 'Kode_Ruangan' },
                { data: 'Nama_Ruangan', name: 'Nama_Ruangan' },
                { data: 'Jenis_Ruangan', name: 'Jenis_Ruangan' },
                { data: 'Jurusan', name: 'Jurusan' },
                { data: 'Aksi', name: 'Aksi' },
            ]
        });
    </script>

@stop 