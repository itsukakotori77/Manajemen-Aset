@extends('layouts.app')

@section('content')

    <div class="min-height-200px">
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
            </div>
        </div>
        <!-- Simple End -->
        <div class="card-box mb-30">
            <div class="pd-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Data Aset</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/aset/data/masuk') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                </div>
            </div>
            
            <form action="{{ url('/aset') }}" method="POST" id="formAset" autocomplete="off" enctype="multipart/form-data">
                <div class="pb-20" style="margin-top: 30px;">
                    <div class="container">
                        <!-- Kondisi -->
                        @if(session('message'))
                            <div class="alert alert-primary" role="alert">
                                <i class="fa fa-bell"></i>
                                {{ session('message') }}
                            </div>
                        @endif
                        <!-- Token -->
                        {{ csrf_field() }}

                        <!-- Input Hidden -->
                        <input type="hidden" id="Total" name="Total">

                        <!-- Nama -->
                        <div class="row">
                            <div class="col-sm-3">
                                <label for="">Kode Aset <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <input type="text" required class="form-control" maxlength="6" id="Kode" name="Kode" placeholder="Kode Aset">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="">Nama Aset <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <input type="text" required class="form-control only-string"  id="Nama_Aset" name="Nama_Aset" placeholder="Nama Aset">
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="">Jenis Aset <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <select name="Jenis_Aset" id="Jenis_Aset" required class="form-control custom-select2" style="width: 100%">
                                        <option selected disabled>-- Pilih --</option>
                                        <option value="1">Berwujud</option>
                                        <option value="2">Habis Pakai</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <label for="">Merek Aset <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <input type="text" required class="form-control"  id="Merek_Aset" name="Merek_Aset" placeholder="Merek Aset">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <!-- Jumlah Aset -->
                            <div class="col-sm-2">
                                <label for="">Jumlah Aset <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <input type="number" min="1" required class="form-control only-number" oninput="total()"  id="Jumlah_Aset" name="Jumlah_Aset" placeholder="Jumlah Aset">
                                </div>
                            </div>
                            <!-- Harga Aset -->
                            <div class="col-sm-5">
                                <label for="">Harga Aset <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <input type="text" required class="form-control only-number" oninput="total()" id="Harga_Aset" name="Harga_Aset" placeholder="Harga Aset">
                                </div>
                            </div>
                            <!-- Kondisi Aset -->
                            <div class="col-sm-5">
                                <label for="">Kondisi Aset <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <select type="text" required class="form-control custom-select2"  id="Kondisi_Aset" name="Kondisi_Aset" placeholder="Kondisi Aset" style="width: 100%">
                                        <option disabled selected="selected">-- Pilih Kondisi --</option>
                                        <option value="1">Baru</option>
                                        <option value="2">Bekas</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Tanggal Penentuan -->
                        <div class="row">
                            <div class="col-sm-4">
                                <!-- Tanggal Masuk -->
                                <div class="form-group">
                                    <label for="">Tanggal Masuk <span style="color: #FF0000;">*</span></label>
                                    <input type="text" required class="form-control date-picker" id="Tanggal_Masuk" name="Tanggal_Masuk_Input" placeholder="Tanggal Masuk dd/mm/YYYY">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- Pengajuan -->
                                <div class="form-group">
                                    <label for="">Pengajuan <span style="color: #FF0000;"></span></label>
                                    <select name="Pengajuan" id="Pengajuan" class="form-control custom-select2" style="width: 100%">
                                        <option selected="selected" disabled>-- Pilih --</option>
                                        @foreach($data['pengajuan'] as $pengajuan)
                                            <option value="{{ $pengajuan->Kode_Pengajuan }}">{{ $pengajuan->Nama_Pengajuan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <label for="Upload Foto">Upload Foto</label>
                                <div class="form-group">
                                    <input type="file" class="form-control uploads" id="Foto" name="Foto_Aset" accept="image/*">
                                </div>
                            </div>
                        </div>

                        <!-- Keterangan -->
                        <div class="row">
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label for="Keterangan">Keterangan <span style="color: #FF0000;">*</span></label>
                                    <div class="form-line">
                                        <textarea name="Keterangan" required class="form-control" id="Keterangan" cols="30" rows="5" placeholder="Keterangan"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <!-- Upload Foto -->
                                <div class="form-group">
                                    <label for="avatar">Foto</label>
                                    <br>
                                    <img class="product" id="avatar" width="100%" height="100%">          
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="form-group">
                            <div class="pull-right">
                                <button type="reset" class="btn btn-danger btn-sm">Reset</button>
                                <button type="submit" class="btn btn-success btn-sm">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


@endsection

@section('js')

    <script>
        $(function(){
            $('.uploads').change(readURL)
            $('#f').submit(function(){
                // do ajax submit or just classic form submit
                //  alert("fake subminting")
                return false;
            });

            // Datepicker
            $('.date-picker').datepicker({
                language: 'en',
                autoClose: true,
                dateFormat: 'dd MM yyyy',
                minDate: new Date()
            });
            
            $('#Tanggal_Pembuatan').datepicker({
                language: 'en',
                autoClose: true,
                dateFormat: 'dd MM yyyy',
            });

        });
        // Set Date
        $('#Tanggal_Masuk').on('changeDate', function(selected) {
            var startDate = new Date(selected.date.valueOf());
            $('#Tanggal_Keluar').datepicker('setStartDate', startDate);
            
            if( lengthDate($('#Tanggal_Masuk').val()) > lengthDate($('#Tanggal_Keluar').val()) ){
                $('#Tanggal_Keluar').val($('#Tanggal_Masuk').val());
            }
        });

        // Jquery Validator
        $("#formAset").validate({
            errorElement: 'div',
            errorPlacement: function (error, element) {
                error.addClass('form-control-feedback');
                element.closest('.form-group').append(error);
            },
            highlight: function (element, errorClass, validClass) {
                // Add Class
                $('.form-group').addClass('has-danger');
                // $('.form-control').addClass('form-control-danger');
            }
        });

        // Message
        @if(session('message'))
            setTimeout(function() {
                $.bootstrapGrowl("{{ session('message') }}", 
                { 
                    type: 'warning',
                    width: '300px;', 
                });
            }, 1000);
        @endif

        function readURL() 
        {
            var input = this;
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#avatar').attr('src', e.target.result);
                    var croppr = new Cropper('#avatar', {
                        onInitialize: (instance) => { console.log(instance); },
                        onCropStart: (data) => { console.log('start', data); },
                        onCropEnd: (data) => { console.log('end', data); },
                        onCropMove: (data) => { console.log('move', data); }
                    });

                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function lengthDate(date)
        {
            var parts = date.split("/");
            return new Date(parts[2], parts[1] - 1, parts[0]);
        }

        function total()
        {
            $('#Total').val(parseInt( $('#Jumlah_Aset').val() * $('#Harga_Aset').val() ));
        }

    </script>

@stop