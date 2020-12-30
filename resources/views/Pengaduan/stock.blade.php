@extends('layouts-front.app')

@section('content')

        <!-- Slider Area End-->
        <!-- What We do start-->
        <div class="what-we-do we-padding">
            <div class="container">
                <!-- Section-tittle -->
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-tittle text-center">
                            <h2>Pengecekan Stock Aset</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12 col-md-6">
                        <div class="single-do text-center mb-30">
                            <div class="do-icon">
                                <span  class="flaticon-tasks"></span>
                            </div>
                            <div class="do-caption">
                                <h4>Mengetahui stock aset yang tersedia</h4>
                                <button type="button" onclick="cekStock()" class="btn btn-primary btn-sm">Cek</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- What We do End-->
        
        <!-- Modal -->
        @include('Pengaduan.modal')

@endsection

@section('js')

    <script src="{{ asset('assets/plugin/sweetalert2/sweetalert.js') }}"></script>
    <script src="{{ asset('assets-front/js/plugin/webcam-scan/webcam-scan.min.js') }}"></script>
    <script>

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

                        $('#modal').modal('hide');
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

            $('#modal').modal('show');
        }

    </script>

@stop 

