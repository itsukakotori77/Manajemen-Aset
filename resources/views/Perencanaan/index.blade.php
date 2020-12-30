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
                    <a href="{{ url('/perencanaan/create') }}" class="btn btn-primary btn-sm"><i class="icon-copy fa fa-plus" aria-hidden="true"></i> <strong>TAMBAH</strong></a>
                    <button type="button" onclick="cekStock()" class="btn btn-info btn-sm"><i class="icon-copy fa fa-search"></i><strong> Cek Stock Aset</strong></button>
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
                                <th>Nama Pengaju</th>
                                <th>Nama Aset</th>
                                <th>Jenis Aset</th>
                                <th>Jumlah Aset</th>
                                <th>Tanggal</th>
                                <th>Ruangan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @include('Perencanaan.modal')
    @include('Perencanaan.modal_check')

@endsection

@section('js')

    <script src="{{ asset('assets-front/js/plugin/webcam-scan/webcam-scan.min.js') }}"></script>
    <script>

        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url('/perencanaan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'Nama_Pengaju', name: 'Nama_Pengaju' },
                { data: 'Nama_Aset', name: 'Nama_Aset' },
                { data: 'Jenis_Aset', name: 'Jenis_Aset' },
                { data: 'Jumlah_Aset', name: 'Jumlah_Aset' },
                { data: 'Tanggal_Perencanaan', name: 'Tanggal_Perencanaan' },
                { data: 'Ruangan', name: 'Ruangan' },
                { data: 'Status', name: 'Status' },
                { data: 'Aksi', name: 'Aksi' },
            ]
        });

        function show(id)
        {
            $.ajax({
                url: "{{ url('/perencanaan') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $('#Nama_Perencanaan').val(data.Nama_Perencanaan);
                    $('#Nama_Pengaju').val(data.Nama_Pengaju);
                    $('#Merek_Aset').val(data.Merek_Aset);
                    $('#Harga_Satuan').val(data.Satuan_Harga);
                    $('#Jumlah_Aset').val(data.Jumlah_Aset);
                    $('#Total_Harga').val(data.Total_Harga);
                    $('#Alasan').val(data.Alasan);
                    $('#modal').modal('show');
                }
            });
        }

        function deleteData(id)
        {
            csrf_token = $('meta[name=csrf_token]').attr('content');

            Swal.fire({
                title: 'Perhatian!',
                text: 'Apakah anda ingin menghapus perencanaan ini ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Hapus'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/perencanaan') }}" + "/" + id,
                        type: "POST",
                        data: {'_method' : 'DELETE', '_token' : csrf_token},
                        success: function(response)
                        {
                            setTimeout(function() {
                                $.bootstrapGrowl('Perencanaan anda telah dihapus', 
                                { 
                                    type: 'success',
                                    width: '300px;', 
                                });
                            }, 1000);
                            
                        }
                    });
                    table.ajax.reload();
                }
            })
        }

        function cekStock()
        {
            let scanner = new Instascan.Scanner({ video: document.getElementById('preview') });
            scanner.addListener('scan', function (content) {
                $.ajax({
                    url : "{{ url('/stock') }}" + "/data" + "/kode" + "/" + content,
                    type : "GET",
                    dataType: "JSON",
                    success : function(data)
                    {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil !!',
                            text: 'Total data aset yang tersedia adalah ' + data.data.Jumlah,
                        });

                        $('#modal_check').modal('hide');
                    }
                });
            });
    
            Instascan.Camera.getCameras().then(function (cameras) {
                if (cameras.length > 0) {
                    scanner.start(cameras[0]);
                } else {
                    console.error('No cameras found.');
                }
            }).catch(function (e) {
                console.error(e);
            });

            $('#modal_check').modal('show');
        }



    </script>

@stop 