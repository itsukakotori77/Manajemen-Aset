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
                    @if(Auth::user()->role_id === 2)
                        <a href="{{ url('/pengajuan/create') }}" class="btn btn-primary btn-sm"><i class="icon-copy fa fa-plus" aria-hidden="true"></i> <strong>TAMBAH</strong></a>
                    @endif
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
                                <th>Nama Pengajuan</th>
                                <th>Tanggal Pengajuan</th>
                                <th>Jurusan</th>
                                <th>Status</th>
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
            ajax: "{{ url('/pengajuan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'Nama_Pengajuan', name: 'Nama_Pengajuan' },
                { data: 'Tanggal_Pengajuan', name: 'Tanggal_Pengajuan' },
                { data: 'Nama_Jurusan', name: 'Nama_Jurusan' },
                { data: 'Status', name: 'Status' },
                { data: 'Aksi', name: 'Aksi' },
            ]
        });

        function ajukan(id)
        {
            csrf_token = $('meta[name=csrf_token]').attr('content');

            Swal.fire({
                title: 'Perhatian!',
                text: 'Apakah anda ingin mengajukan pengajuan ini ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ajukan'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/pengajuan') }}" + "/" + id + "/" + "ajukan",
                        type: "POST",
                        data: {'_method' : 'PUT', '_token' : csrf_token},
                        success: function(response)
                        {
                            setTimeout(function() 
                            {
                                $.bootstrapGrowl('Pengajuan berhasil diajukan', 
                                { 
                                    type: 'success',
                                    width: '300px;', 
                                });
                            }, 1000);
                            table.ajax.reload();
                        }
                    });
                }
            })
        }

        function setujui(id)
        {
            // code block
            csrf_token = $('meta[name=csrf_token]').attr('content');

            Swal.fire({
                title: 'Perhatian!',
                text: 'Apakah anda ingin menyetujui pengajuan ini ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/pengajuan') }}" + "/" + id + "/" + "persetujuan" + "/" + "Setujui",
                        type: "POST",
                        data: {'_method' : 'PUT', '_token' : csrf_token},
                        success: function(response)
                        {
                            setTimeout(function() 
                            {
                                $.bootstrapGrowl('Pengajuan disetujui', 
                                { 
                                    type: 'success',
                                    width: '300px;', 
                                });
                            }, 1000);
                            table.ajax.reload();
                        }
                    });
                }
            });
        }

        function tolak(id)
        {
            // code block
            csrf_token = $('meta[name=csrf_token]').attr('content');

            Swal.fire({
                title: 'Perhatian!',
                text: 'Apakah anda ingin menolak pengajuan ini ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/pengajuan') }}" + "/" + id + "/" + "persetujuan" + "/" + "Tolak",
                        type: "POST",
                        data: {'_method' : 'PUT', '_token' : csrf_token},
                        success: function(response)
                        {
                            setTimeout(function() 
                            {
                                $.bootstrapGrowl('Pengajuan ditolak', 
                                { 
                                    type: 'success',
                                    width: '300px;', 
                                });
                            }, 1000);
                            table.ajax.reload();
                        }
                    });
                }
            });
        }

    </script>

@stop 