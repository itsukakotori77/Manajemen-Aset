@extends('layouts.app')

@section('content')

    <div class="min-height-200px">
        <div class="page-header">
            <div class="row">
                <div class="col-md-6 col-sm-12">
                    <div class="title">
                        <h4>Tambah Pegawai</h4>
                    </div>
                    <nav aria-label="breadcrumb" role="navigation">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Pegawai</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <!-- Simple Tambah Pegawai End -->
        <div class="card-box mb-30">
            <div class="pd-20">
                <div class="pull-left">
                    <h4 class="text-blue h4">Data Pegawai</h4>
                </div>
                <div class="pull-right">
                    <a href="{{ url('/pegawai') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                </div>
            </div>
            <form action="{{ url('/pegawai') }}" method="POST" id="formPegawai" autocomplete="off" enctype="multipart/form-data">
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
                        <!-- Nama -->
                        <div class="row">
                            <div class="col-sm-6">
                                <label for="">Nama Depan <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control only-string"  id="Nama_Depan" name="Nama_Depan" placeholder="Nama Depan">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <label for="">Nama Belakang <span style="color: #FF0000;">*</span></label>
                                <div class="form-group">
                                    <input type="text" class="form-control only-string"  id="Nama_Belakang" name="Nama_Belakang" placeholder="Nama Belakang">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Jenis Kelamin -->
                                <div class="form-group">
                                    <label for="">Jenis Kelamin <span style="color: #FF0000;">*</span></label>
                                    <select name="Jenis_Kelamin"  id="Jenis_Kelamin" class="form-control custom-select2" style="width: 100%">
                                        <option selected disabled>-- Pilih --</option>
                                        <option value="1">Laki - laki</option>
                                        <option value="2">Perempuan</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Agama -->
                                <div class="form-group">
                                    <label for="">Agama <span style="color: #FF0000;">*</span></label>
                                    <select name="Agama"  id="Agama" class="form-control custom-select2" style="width: 100%">
                                        <option selected disabled>-- Pilih --</option>
                                        <option value="1">Islam</option>
                                        <option value="2">Protestan</option>
                                        <option value="3">Katolik</option>
                                        <option value="4">Hindu</option>
                                        <option value="5">Buddha</option>
                                        <option value="6">Khonghucu</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Role -->
                        <div class="form-group">
                            <label for="">Pilih Role <span style="color: #FF0000;">*</span></label>
                            <select name="Role"  id="Role" class="form-control custom-select2" style="width: 100%">
                                <option selected disabled>-- Pilih --</option>
                            </select>
                        </div>

                        <!-- Alamat -->
                        <div class="form-group form-float">
                            <label for="Alamat">Alamat <span style="color: #FF0000;">*</span></label>
                            <div class="form-line">
                                <textarea name="Alamat" required class="form-control" id="Alamat" cols="30" rows="5" placeholder="Alamat"></textarea>
                            </div>
                        </div>

                        <!-- TTL -->
                        <div class="row">
                            <!-- Tempat Lahir -->
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Tempat Lahir <span style="color: #FF0000;">*</span></label>
                                    <input type="text" class="form-control"  id="Tempat_Lahir" name="Tempat_Lahir" placeholder="Tempat Lahir">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Tanggal Lahir <span style="color: #FF0000;">*</span></label>
                                    <input type="text" class="form-control date-picker" id="Tanggal_Lahir" name="Tanggal_Lahir" placeholder="Tanggal Lahir dd/mm/YYYY">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- NIP -->
                                <div class="form-group">
                                    <label for="">Nomor Induk Pegawai <span style="color: #FF0000;">*</span></label>
                                    <input type="text" class="form-control only-number" id="NIP" name="NIP" minlength="12" placeholder="NIP">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="">Jurusan <span style="color: #FF0000;">*</span></label>
                                    <select name="Jurusan" id="Jurusan" class="form-control custom-select2">
                                        <option selected="selected" disabled>-- Pilih Jurusan --</option>
                                        @foreach($data['jurusan'] as $jurusan)
                                            <option value="{{ $jurusan->Kode_Jurusan }}">{{ $jurusan->Nama_Jurusan }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <!-- Username -->
                                <div class="form-group">
                                    <label for="">Username <span style="color: #FF0000;">*</span></label>
                                    <input type="text" class="form-control only-lowercase" id="Username" name="Username" placeholder="Username">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <!-- Email -->
                                <div class="form-group">
                                    <label for="">Email <span style="color: #FF0000;">*</span></label>
                                    <input type="email" class="form-control" id="Email" name="Email" placeholder="Email">
                                </div>
                            </div>
                        </div>

                        <!-- Upload Foto -->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="Upload Foto">Upload Foto</label>
                                    <input type="file" class="form-control uploads" id="Foto" name="Foto_Avatar" accept="image/*">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="avatar">Foto</label>
                                    <br>
                                    <img class="product" id="avatar" width="250" height="200">          
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
                </form>
            </div>
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
            $.ajax({
                url: "{{ url('/role/data') }}",
                type: "GET",
                dataType: "JSON",
                success: function(data)
                {
                    $.each(data,function(role, value)
                    {
                        $("#Role").append('<option value="'+ value.id +'">'+value.role+ '</option>');
                    });
                }
            });
        });

        // Jquery Validator
        $("#formPegawai").validate({
            // Rules
            rules: {
                Nama_Depan: "required",
                Nama_Belakang: "required",
                Jenis_Kelamin: "required",
                Agama: "required",
                Role: "required",
                Tempat_Lahir: "required",
                Tanggal_Lahir: "required",
                Alamat: "required",
                NIP: "required",
                Jurusan: "required",
                Username: "required",
                Email: {
                    required: true,
                    email: true
                },
            },
            // Specify validation error messages
            messages: {
                Nama_Depan: "Tolong masukkan Nama Depan",
                Nama_Belakang: "Tolong masukkan Nama Belakang",
                Jenis_Kelamin: "Tolong pilih jenis kelamin",
                Agama: "Tolong pilih agama (kecuali kalo ateis)",
                Role: "Tolong pilih role",
                Tempat_Lahir: "Tolong masukkan tempat lahir",
                Tanggal_Lahir: "Tolong masukkan tanggal lahir",
                Alamat: "Tolong masukkan alamat",
                NIP: "Tolong masukkan NIP",
                Jurusan: "Tolong masukkan jurusan",
                Username: "Tolong masukkan username",
                Email: "Tolong masukkan email",
            },
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

    </script>

@stop