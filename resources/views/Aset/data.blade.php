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

            <!-- Data Aset -->
            <div class="pd-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Data Aset</h4>
                </div>
                @if($method === 'masuk')
                    <div class="pull-right">
                        <a href="{{ url('/aset/create') }}" class="btn btn-primary btn-sm"><i class="icon-copy fa fa-plus" aria-hidden="true"></i> <strong>TAMBAH</strong></a>
                    </div>
                @endif
            </div>
            <div class="pb-20" style="margin-top: 30px;">
                <div class="container">
                    <!-- Kondisi -->
                    @if(session('message'))
                        <div class="alert alert-success" role="alert">
                            <i class="fa fa-bell"></i>
                            {{ session('message') }}
                        </div>
                    @endif`

                    <!-- Table -->
                    <table class="data-table table datatable" style="width: 100%">
                        <thead>
                            @if($method === 'penetapan')
                                <tr>
                                    <th>Aset</th>
                                    <th>Nama Aset</th>
                                    <th>Jenis Aset</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Ruangan</th>
                                    <th>Jumlah Penempatan</th>
                                </tr>
                            @else
                                <tr>
                                    <th>Aset</th>
                                    <th>Nama Aset</th>
                                    <th>Jenis Aset</th>
                                    <th>Jumlah Aset</th>
                                    <th>Jumlah Tersedia</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Aksi</th>
                                </tr>
                            @endif
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('Aset.modal')

@endsection


@section('js')

    <script>

        var table1 = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url('/aset') }}" + "/" + "data" + "/" + "{{ $method }}",
            columns: [
                @if($method === 'penetapan')
                    // { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                    { data: 'Foto', name: 'Foto' },
                    { data: 'Nama_Aset', name: 'Nama_Aset' },
                    { data: 'Jenis_Aset', name: 'Jenis_Aset' },
                    { data: 'Tanggal_Masuk', name: 'Tanggal_Masuk' },
                    { data: 'Penempatan_Aset', name: 'Penempatan_Aset' },
                    { data: 'Jumlah_Penempatan', name: 'Jumlah_Penempatan' },
                @else 
                    { data: 'Foto', name: 'Foto' },
                    { data: 'Nama_Aset', name: 'Nama_Aset' },
                    { data: 'Jenis_Aset', name: 'Jenis_Aset' },
                    { data: 'Jumlah_Aset', name: 'Jumlah_Aset' },
                    { data: 'Jumlah', name: 'Jumlah' },
                    { data: 'Tanggal_Masuk', name: 'Tanggal_Masuk' },
                    { data: 'Aksi', name: 'Aksi' },
                @endif
            ],
            columnDefs: [ {
                orderable: false,
                className: 'select-checkbox',
                targets:   0
            } ],
            select: {
                style:    'os',
                selector: 'td:first-child'
            },
        });


        function show(id)
        {
            $.ajax({
                url: "{{ url('/aset') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    if(data.Jenis_Aset === 1)
                        $('#Jenis_Aset').text('Aset Berwujud');
                    else
                        $('#Jenis_Aset').text('Tidak Berwujud');

                    // Input
                    $('#Nama_Aset').text(data.Nama_Aset);
                    $('#Merek_Aset').text('Merek Aset : ' + data.Merek_Aset);
                    $('#Jumlah_Aset').text('Jumlah Aset : ' + data.Jumlah_Aset);
                    $('#Harga_Aset').text('Harga Aset : Rp. ' + data.Harga_Aset);
                    $('#Total_Harga').text('Total Harga Aset : Rp.' + data.Total_Harga);
                    $('#Keterangan').text(data.Keterangan);

                    if(data.QrCode != '')
                    {
                        $('#generate').attr('hidden', true);
                        $('#QrCode_Aset').attr('src', "{{ asset('/data/QrCode-Aset') }}" + "/" + data.QrCode);
                    }else{
                        $('#generate').attr('hidden', false);
                        $('#generate').attr('onclick', 'generate(' + data.Kode_Aset + ')');
                        $('#QrCode_Aset').attr('src', "{{ asset('/data/QrCode-Aset/no-qrcode.png') }}");
                    }

                    $('#modal').modal('show');
                }
            });
            
        }

        function generate(id)
        {
            csrf_token = $('meta[name=csrf_token]').attr('content');

            $.ajax({
                url: "{{ url('/aset') }}" + "/" + id + "/generate" + "/qrcode",
                type: "POST",
                data: {'_method' : 'PUT', '_token' : csrf_token},
                success: function(data)
                {
                    setTimeout(function() 
                    {
                        $.bootstrapGrowl('QrCode telah berhasil dibuat', 
                        { 
                            type: 'success',
                            width: '300px;', 
                        });
                    }, 1000);
                    $('#generate').attr('hidden', true);
                    $('#QrCode_Aset').attr('src', "{{ asset('/data/QrCode-Aset') }}" + "/" + data.QrCode);
                }
            });

        }
        
    </script>

@stop 