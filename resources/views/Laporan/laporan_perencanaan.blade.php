@extends('layouts.app')

@section('content')

    <div class="page-header">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="title">
                    <h4>{{ $data['title'] }}</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $data['title'] }}</li>
                    </ol>
                </nav>
            </div>
            <div class="col-md-6">
                <div class="pull-right">
                    <form action="{{ url('/laporan/download/perencanaan') }}" method="POST" id="form-laporan">
                        {{ csrf_field() }}
                        <input type="hidden" name="Tanggal" id="Tanggal">
                    </form>
                    <button type="button" class="btn btn-info dropdown-toggle waves-effect" data-toggle="dropdown" aria-expanded="false"> 
                        Download Laporan 
                        <span class="caret"></span> 
                    </button>
                    <div class="dropdown-menu">
                        @for($i=1;$i<=12;$i++)
                            <?php $tanggal = date('Y-'. $i .'-d'); ?>
                            <a class="dropdown-item" onclick="downloadLaporan('{{ $tanggal }}')" href="#">{{ date('F', strtotime($tanggal)) }}</a>
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xl-12 mb-30">
            <div class="card-box height-100-p pd-20">
                <h4 class="h4 text-blue">Statistik Perencanaan Perbulan</h4>
                <div id="chart5"></div>
            </div>
        </div>
    </div>

@endsection 

@section('js')

    <script src="{{ asset('assets/plugin/apexcharts/apexcharts.min.js') }}"></script>
    <script>

        // Category
        var tanggal = [];
        for(i=0;i<=30;i++)
        {
            var first = moment().startOf('month').format('MM/DD/YYYY');
            tanggal[i] = moment(first).add(i, 'days').format('MM/DD/YYYY');
        }

        data_perencanaan = [
            @foreach($data['perencanaan'] as $perencanaan)
                parseInt("{{ $perencanaan }}"),
            @endforeach
        ];

        var options5 = {
            series: [{
                name: 'Perencanaan',
                type: 'area',
                data: data_perencanaan,
            }],
            chart: {
                height: 350,
                type: 'line',
                stacked: false,
                toolbar: {
                    show: false,
                }
            },
            grid: {
                show: false,
                padding: {
                    left: 0,
                    right: 0
                }
            },
            stroke: {
                width: [0, 2, 5],
                curve: 'smooth'
            },
            plotOptions: {
                bar: {
                    columnWidth: '20%'
                }
            },

            fill: {
                opacity: [0.85, 0.25, 1],
                gradient: {
                    inverseColors: false,
                    shade: 'light',
                    type: "vertical",
                    opacityFrom: 0.85,
                    opacityTo: 0.55,
                    stops: [0, 100, 100, 100]
                }
            },
            labels: tanggal,
            markers: {
                size: 0
            },
            xaxis: {
                type: 'datetime'
            },
            yaxis: {
                title: {
                    text: 'Jumlah',
                },
                min: 0
            },
            tooltip: {
                shared: true,
                intersect: false,
                y: {
                    formatter: function (y) {
                        if (typeof y !== "undefined") {
                            return y.toFixed(0) + " points";
                        }
                        return y;

                    }
                }
            }
        };
        var chart = new ApexCharts(document.querySelector("#chart5"), options5);
        chart.render();

        function downloadLaporan(tanggal)
        {
            $('#Tanggal').val(tanggal);
            $('#form-laporan').submit();
        }


    </script>

@stop 