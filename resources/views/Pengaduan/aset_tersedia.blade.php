@extends('layouts-front.app')

@section('content')

        <!-- Slider Area Start-->
        <div class="services-area">
            <div class="container">

                <!-- Section-tittle -->
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-tittle text-center mb-80">
                            <span>Data</span>
                            <h2>Data Aset yang tersedia​</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Area End-->
        <!-- What We do start-->
        <div class="what-we-do">
            <div class="container">
                <div class="row">
                    @if(count($data) > 0)
                        <div class="col-sm-8" style="margin: auto">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Aset</th>
                                        <th>Tanggal Masuk</th>
                                        <th>Jumlah Tersedia</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        @foreach($data as $data)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $data->Nama_Aset }}</td>
                                                <td>{{ $data->Jumlah }}</td>
                                            </tr>
                                        @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="col-lg-6 col-md-6" style="margin: auto">
                            <div class="single-do text-center mb-30">
                                <div class="do-icon">
                                    <span  class="flaticon-tasks"></span>
                                </div>
                                <div class="do-caption">
                                    <h4>Data tidak tersedia</h4>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- What We do End-->

@endsection 