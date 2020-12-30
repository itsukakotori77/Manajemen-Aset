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
        <div class="row">
            <div class="col-sm-4" style="height: 100%;">
                <div class="card-box pd-30" >
                    <div class="progress-box text-center">
                        <input type="text" class="knob dial3" value="90" data-width="120" data-height="120" data-linecap="round" data-thickness="0.12" data-bgColor="#fff" data-fgColor="#f56767" data-angleOffset="180" readonly>
                        <h5 class="text-light-orange padding-top-10 h5">Total Aset yang dihapus</h5>
                    </div>
                </div>
            </div>
            <div class="col-sm-8">
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
                                        <th>Tanggal Penghapusan</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection 

@section('js')

    <script src="{{ asset('assets/plugin/jQuery-Knob-master/jquery.knob.min.js') }}"></script>
    <script>
        $(".dial3").knob();
        $({animatedVal: 0}).animate({animatedVal: parseInt("{{ $count }}")}, {
            duration: 3000,
            easing: "swing",
            step: function() {
                $(".dial3").val(Math.ceil(this.animatedVal)).trigger("change");
            }
        });

        var table = $('.datatable').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            searching: false, 
            info: false,
            bLengthChange: false,
            bFilter: true,
            bInfo: false,
            bAutoWidth: false,
            ajax: "{{ url('/penghapusan') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex' },
                { data: 'Ruangan', name: 'Ruangan' },
                { data: 'Nama_Aset', name: 'Nama_Aset' },
                { data: 'Tanggal_Penghapusan', name: 'Tanggal_Penghapusan' },
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

    </script>

@stop 