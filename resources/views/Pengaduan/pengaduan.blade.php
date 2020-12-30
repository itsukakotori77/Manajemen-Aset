@extends('layouts-front.app')

@section('css')

    <style>

        .nice-select{
            width: 100%;
        }

        .col-sm-12{
            margin-top: 7px;
        }

    </style>

@stop 

@section('content')

        <!-- Slider Area Start-->
        <div class="services-area">
            <div class="container">

                <!-- Section-tittle -->
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-tittle text-center mb-80">
                            <span>Pengaduan Aset</span>
                            <h2>Aset yang dapat diadukan berupa aset yang telah mengalami kerusakan</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Area End-->
        <!-- What We do start-->
        <div class="what-we-do">
            <div class="container">
                @if(session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                @endif 
                <div class="row">
                    <div class="col-sm-4" style="margin: auto;">
                        <img src="{{ asset('assets-front/img/post/complaint.png') }}" alt="">
                    </div>
                    <div class="col-sm-6" style="margin: auto">
                        <form action="{{ url('/pengaduan/aset') }}" method="POST" id="form-pengaduan">
                            {{ csrf_field() }}

                            <!-- Aset -->
                            <div class="row">
                                <div class="col-sm-8">
                                    <!-- Nama Aset -->
                                    <label for="Aset">Nama Aset <span style="color: #FF0000">*</span></label>
                                    <div class="form-group">
                                        <select name="Aset_ID" required id="Aset" class="form-control" style="width: 100%">
                                            <option disabled selected="selected">-- Pilih --</option>
                                            @foreach($data['aset'] as $aset)
                                                <option value="{{ $aset->Kode_Aset }}">{{ $aset->Nama_Aset }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <label for="">Total Rusak <span style="color: #FF0000">*</span></label>
                                    <div class="form-group">
                                        <input type="number" required min="1" class="form-control" name="Total_Rusak" id="Total_Rusak" placeholder="Total Rusak">
                                    </div>
                                </div>
                            </div>

                            <!-- Lokasi -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- Lokasi -->
                                    <label for="Lokasi">Lokasi <span style="color: #FF0000">*</span></label>
                                    <div class="form-group">
                                        <select name="Ruangan_ID" required id="Lokasi" class="form-control" style="width: 100%">
                                            <option disabled selected="selected">-- Pilih --</option>
                                            @foreach($data['ruangan'] as $ruangan)
                                                <option value="{{ $ruangan->Ruangan_ID }}">{{ $ruangan->Kode_Ruangan . ' ' . $ruangan->Nama_Ruangan }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Kerusakan -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- Rusak -->
                                    <label for="Kerusakan">Jenis Kerusakan <span style="color: #FF0000">*</span></label>
                                    <div class="form-group">
                                        <select name="Kerusakan" required id="Kerusakan" class="form-control" style="width: 100%">
                                            <option disabled selected="selected">-- Pilih --</option>
                                            <option value="1">Rusak Ringan</option>
                                            <option value="2">Rusak Berat</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <!-- Alasan -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="">Alasan <span style="color: #FF0000">*</span></label>
                                    <div class="form-group">
                                        <textarea name="Alasan" required id="Alasan" cols="30" rows="5" class="form-control" placeholder="Alasan"></textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" class="btn btn-primary btn-block">Adukan</button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- What We do End-->

@endsection 

@section('js')

    <script src="{{ asset('assets-front/js/plugin/jquery-validation/jquery.validate.js') }}"></script>
    <script>
        // Jquery Validator
        $("#form-pengaduan").validate({
            // Rules
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('form-control-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                // Add Class
                $('.form-group').addClass('has-danger');
            }
        });

        $('#Aset').on('change', function (e) {
            var optionSelected = $("option:selected", this);
            var id = this.value;

            $.ajax({
                url: "{{ url('/stock/data') }}" + "/" + id,
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    // count = Object.keys(data).length;
                    $('#Total_Rusak').attr('max', data.Jumlah);
                }
            });
        });


    </script>

@stop 