@extends('layouts.app')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tabel Pegawai</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tabel Pegawai</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Simple Tabel Pegawai End -->
        <!-- multiple select row Datatable start -->
        <div class="card-box mb-30">
            <div class="pd-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Data Pegawai</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/pegawai/create') }}" class="btn btn-primary btn-sm"><i class="icon-copy fa fa-user-plus" aria-hidden="true"></i> <strong>TAMBAH</strong></a>
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
                                <th>Foto</th>
                                <th>Nama</th>
                                <th>Jenis Kelamin</th>
                                <th>Username</th>
                                <th>Jabatan</th>
                                <!-- <th>Alamat</th>
                                <th>Tempat Lahir</th>
                                <th>Tanggal Lahir</th> -->
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @include('Pegawai.modal')

@endsection 

@section('js')

    <script> 

        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            ajax: "{{ url('/pegawai') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'Foto', name: 'Foto' },
                { data: 'Nama', name: 'Nama' },
                { data: 'Jenis_Kelamin', name: 'Jenis_Kelamin' },
                { data: 'Username', name: 'Username' },
                { data: 'Role', name: 'Role' },
                // { data: 'Alamat', name: 'Alamat' },
                // { data: 'Tempat_Lahir', name: 'Tempat_Lahir' },
                // { data: 'Tanggal_Lahir', name: 'Tanggal_Lahir' },
                { data: 'Status', name: 'Status' },
                { data: 'Aksi', name: 'Aksi' },
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


        // Message
        @if(session('message'))
            setTimeout(function() {
                $.bootstrapGrowl("{{ session('message') }}", 
                { 
                    type: 'success',
                    width: '300px;', 
                });
            }, 1000);
        @endif

        function showData(id)
        {
            $.ajax({
                url: "{{ url('/pegawai') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    // alert(data.user.username);
                    $('#Name').text(data.pegawai.Nama_Depan + ' ' + data.pegawai.Nama_Belakang);
                    $('#Username_User').text(data.user.username);
                    $('#Email_User').text(data.user.email);

                    // Kondisi
                    if(data.user.role_id == 1)
                        $('#Role_User').text('Admin');
                    else if(data.user.role_id == 2)
                        $('#Role_User').text('Ketua Kompentensi');
                    else if(data.user.role_id == 3)
                        $('#Role_User').text('Sarpras');
                    else if(data.user.role_id == 4)
                        $('#Role_User').text('Pengguna Aset');
                    else if(data.user.role_id == 5)
                        $('#Role_User').text('TU Aset');
                    else if(data.user.role_id == 6)
                        $('#Role_User').text('Guru');
                    
                    // Alamat
                    $('#Alamat_User').text(data.pegawai.Alamat);

                    // Foto
                    if(data.pegawai.Foto == '')
                        $('#foto-user').attr('src', "https://ui-avatars.com/api/?name=. $data->Nama_Depan . + . $data->Nama_Belakang . &background=0D8ABC&color=fff");
                    else 
                        $('#foto-user').attr('src', "{{ asset('assets/images/foto-user') }}" + "/" + data.pegawai.Foto);
                    
                    $('#modal').modal('show');
                }
            });

        }

        function ubahStatus(id)
        {
            // code block
            csrf_token = $('meta[name=csrf_token]').attr('content');

            Swal.fire({
                title: 'Perhatian!',
                text: 'Apakah anda ingin mengubah status pegawai ini ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/user') }}" + "/" + id + "/status",
                        type: "POST",
                        data: {'_method' : 'PUT', '_token' : csrf_token},
                        success: function(response)
                        {
                            setTimeout(function() 
                            {
                                $.bootstrapGrowl('Status berhasil diubah', 
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