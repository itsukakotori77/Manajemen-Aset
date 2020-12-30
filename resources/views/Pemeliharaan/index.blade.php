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
            </div>
            <div class="pb-20" style="margin-top: 30px;">
                <div class="container">

                    <!-- Table -->
                    <table class="data-table table datatable" style="width: 100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Ruangan</th>
                                <th>Nama Aset</th>
                                <th>Tanggal Pemeliharaan</th>
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
            ajax: "{{ url('/pemeliharaan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'Ruangan', name: 'Ruangan' },
                { data: 'Nama_Aset', name: 'Nama_Aset' },
                { data: 'Tanggal_Pemeliharaan', name: 'Tanggal_Pemeliharaan' },
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

        function selesai(id)
        {
            // code block
            csrf_token = $('meta[name=csrf_token]').attr('content');

            Swal.fire({
                title: 'Perhatian!',
                text: 'Apakah anda ingin mengubah status perbaikan aset ini menjadi selesai ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/pemeliharaan') }}" +  "/" + id + "/status" + "/" + "selesai",
                        type: "POST",
                        data: {'_method' : 'PUT', '_token' : csrf_token},
                        success: function(response)
                        {
                            setTimeout(function() 
                            {
                                $.bootstrapGrowl('Aset selesai diperbaiki', 
                                { 
                                    type: 'success',
                                    width: '300px;', 
                                });
                            }, 1000);
                            
                        }
                    });
                    table.ajax.reload();
                }
            });
        }

        function kembalikan(id)
        {
            // code block
            csrf_token = $('meta[name=csrf_token]').attr('content');

            Swal.fire({
                title: 'Perhatian!',
                text: 'Apakah anda ingin mengembalikan aset yang telah selesai diperbaiki ?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('/pemeliharaan') }}" +  "/" + id + "/status" + "/" + "dikembalikan",
                        type: "POST",
                        data: {'_method' : 'PUT', '_token' : csrf_token},
                        success: function(response)
                        {
                            setTimeout(function() 
                            {
                                $.bootstrapGrowl('Aset dikembalikan', 
                                { 
                                    type: 'success',
                                    width: '300px;', 
                                });
                            }, 1000);
                            
                        }
                    });
                    table.ajax.reload();
                }
            });
        }

    </script>

@stop 