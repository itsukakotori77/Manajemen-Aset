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
                    <a href="{{ url('/perencanaan') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                </div>
            </div>
            <div class="pb-20" style="margin-top: 30px;">
                <div class="container">
                    <!-- Form -->
                    <form action="{{ url('/perencanaan') }}" method="POST" autocomplete="off" id="formPerencanaan">
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Nama Perencanaan -->
                                <div class="form-group">    
                                    <label for="">Nama Perencanaan <span style="color: #FF0000">*</span> </label>
                                    <input type="text" class="form-control" id="Nama_Perencanaan" name="Nama_Perencanaan" placeholder="Nama Perencanaan">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Ruangan <span style="color: #FF0000">*</span></label>
                                    <select id="Ruangan" style="width: 100%" name="Ruangan" class="form-control">
                                        <option selected="selected" disabled>-- Pilih --</option>
                                        @foreach($data['ruangan'] as $ruangan)
                                            <option value="{{ $ruangan->ID_Ruangan }}">{{ $ruangan->Nama_Ruangan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Aset -->
                        <div class="row">
                            <!-- Nama Aset -->
                            <div class="col-sm-6">
                                <div class="form-group">    
                                    <label for="">Nama Aset <span style="color: #FF0000">*</span> </label>
                                    <input type="text" class="form-control" id="Nama_Aset" name="Nama_Aset" placeholder="Nama Aset">
                                </div>
                            </div>
                            <!-- Jenis Aset -->
                            <div class="col-sm-6">
                                <div class="form-group">    
                                    <label for="">Jenis Aset <span style="color: #FF0000">*</span> </label>
                                    <select class="form-control custom-select2" style="width: 100%;" id="Jenis_Aset" name="Jenis_Aset" placeholder="Jenis Aset">
                                        <option selected="selected" disabled>-- Pilih Jenis --</option>
                                        <option value="1">Aset Tetap</option>
                                        <option value="2">Aset Habis Pakai</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Merk Aset -->
                        <div class="row">
                            <div class="col-sm-8">
                                <!-- Merek Aset -->
                                <div class="form-group">
                                    <label for="">Merek Aset <span style="color: #FF0000">*</span> </label>
                                    <input type="text" class="form-control" name="Merek_Aset" id="Merek_Aset" placeholder="Merek Aset">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- Jumlah Aset -->
                                <div class="form-group">
                                    <label for="">Kuantitas <span style="color: #FF0000">*</span> </label>
                                    <input type="number" oninput="total()" min="1" class="form-control" id="Kuantitas" name="Kuantitas" placeholder="Jumlah Aset">
                                </div>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Satuan Harga -->
                                <div class="form-group">
                                    <label for="">Satuan Harga <span style="color: #FF0000">*</span> </label>
                                    <input type="text" oninput="total()" class="form-control only-number" name="Satuan_Harga" id="Satuan_Harga" placeholder="Satuan Harga">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Total Harga -->
                                <div class="form-group">
                                    <label for="">Total Harga <span style="color: #FF0000">*</span> </label>
                                    <input type="text" class="form-control only-number" name="Total_Harga" id="Total_Harga" placeholder="Total Harga" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Alasan -->
                        <div class="form-group">
                            <label for="">Alasan Perencanaan <span style="color: #FF0000">*</span> </label>
                            <textarea class="form-control" name="Alasan" id="Alasan" cols="30" rows="5" placeholder="Alasan Perencanaan"></textarea>
                        </div>

                        <!-- button -->
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="pull-right">
                                    <button type="reset" class="btn btn-danger btn-sm">RESET PERENCANAAN</button>
                                    <button type="submit" class="btn btn-success btn-sm">SIMPAN</button>
                                </div>
                            </div>
                        </div>
                        
                    </form>
                    
                </div>
            </div>
        </div>
    </div>

@endsection

@section('js')

    <script>
        // Jquery Validator
        $("#formPerencanaan").validate({
            // Rules
            rules: {
                Nama_Perencanaan: "required",
                Nama_Aset: "required",
                Jenis_Aset: "required",
                Merek_Aset: "required",
                Kuantitas: "required",
                Satuan_Harga: "required",
                Total_Harga: "required",
                Alasan: "required",
                Ruangan: "required",
            },
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


        function total()
        {
            hasil = parseInt($('#Kuantitas').val()) * parseInt($('#Satuan_Harga').val());
            // $('#Total_Harga').val( numberWithCommas(hasil) );
            $('#Total_Harga').val( hasil );
        }

        function numberWithCommas(x) 
        {
            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

    </script>

@stop 