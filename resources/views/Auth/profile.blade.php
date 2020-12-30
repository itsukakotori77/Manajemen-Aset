@extends('layouts.app')

@section('content')

    <div class="page-header">
        @if(session('message'))
            <div class="alert alert-success" role="alert">
                <i class="fa fa-bell"></i> {{ session('message') }}
            </div>
        @endif
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="title">
                    <h4>Profile</h4>
                </div>
                <nav aria-label="breadcrumb" role="navigation">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Profile</li>
                    </ol>
                </nav>
            </div>
            <div class="col-sm-6">
                <div class="pull-right">
                    <a href="{{ url('/dashboard') }}" class="btn btn-info btn-sm"><strong>KEMBALI</strong></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-30">
            <div class="pd-20 card-box">
                <div class="profile-photo">
                    @if($user->avatar == '')
                        @if(Auth::user()->role_id == 1)
                            <img src="https://ui-avatars.com/api/?name={{ $user->username }}&background=0D8ABC&color=fff" alt="" id="avatar" class="avatar-photo" style="width: 200px; height: 160px;">
                        @else 
                            <img src="https://ui-avatars.com/api/?name={{ $user->pegawai->Nama_Depan . '+' . $user->pegawai->Nama_Belakang }}&background=0D8ABC&color=fff" alt="" id="avatar" class="avatar-photo" style="width: 200px; height: 160px;">
                        @endif
                    @else 
                        <img src="{{ asset('assets/images/foto-user/' . $user->avatar) }}" alt="" id="avatar" class="avatar-photo" style="width: 200px; height: 160px;">
                    @endif
                </div>

                <!-- Username -->
                @if(Auth::user()->role_id != 1)
                    <h5 class="text-center h5 mb-0">{{ $user->pegawai->Nama_Depan . ' ' . $user->pegawai->Nama_Belakang }}</h5>
                @else 
                    <h5 class="text-center h5 mb-0">{{ $user->username }}</h5>
                @endif

                <!-- Role -->
                @if($user->role_id === 1)
                    <p class="text-center text-muted font-14">Admin</p>
                @elseif($user->role_id === 2)
                    <p class="text-center text-muted font-14">Ketua Kompetensi</p>
                @elseif($user->role_id === 3)
                    <p class="text-center text-muted font-14">Ketua Sarpras</p>
                @elseif($user->role_id === 4)
                    <p class="text-center text-muted font-14">Pengguna Aset</p>
                @elseif($user->role_id === 5)
                    <p class="text-center text-muted font-14">TU Sarpras</p>
                @else 
                    <p class="text-center text-muted font-14">Guru</p>
                @endif 
                <div class="profile-info">
                    <h5 class="mb-20 h5 text-blue">Informasi Kontak</h5>
                    <ul>
                        <li>
                            <span>Email Address:</span>
                            {{ $user->email }}
                        </li>
                        @if(Auth::user()->role_id != 1)
                            <li>
                                @if($user->pegawai->Jenis_Kelamin === 1)
                                    <span>Jenis Kelamin:</span>
                                    Laki - laki
                                @else 
                                    <span>Jenis Kelamin:</span>
                                    Perempuan
                                @endif 
                            </li>
                            <li>
                                <span>Alamat:</span>
                                {{ $user->pegawai->Alamat }}
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-xl-8 col-lg-8 col-md-8 col-sm-12 mb-30">
            <div class="card-box height-100-p overflow-hidden">
                <div class="profile-tab height-100-p">
                    <div class="tab height-100-p">
                        <ul class="nav nav-tabs customtab" role="tablist">
                            <li class="nav-item active">
                                <a class="nav-link active" data-toggle="tab" href="#setting" role="tab">Settings</a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane fade show active height-100-p" id="setting" role="tabpanel">
                                <div class="profile-setting">
                                    <form method="POST" action="{{ url('/user/' . $user->id . '/profile') }}" enctype="multipart/form-data" autocomplete="off">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }}
                                        <ul class="profile-edit-list row">
                                            <li class="weight-500 col-md-12">
                                                <h4 class="text-blue h5 mb-20">Ubah data user</h4>
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="email" class="form-control form-control-lg" id="Email" name="Email" value="{{ $user->email }}">
                                                </div>
                                                <div class="form-group">
                                                    <label>Username</label>
                                                    <input type="text" class="form-control form-control-lg" id="Username" name="Username" value="{{ $user->username }}">
                                                </div>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Password</label>
                                                            <input type="password" oninput="check()" class="form-control form-control-lg" id="Password" name="Password">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <div class="form-group">
                                                            <label>Retype - Password</label>
                                                            <input type="password" oninput="check()" class="form-control form-control-lg" id="Retype_Password" name="Retype_Password">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label>Upload Foto</label>
                                                    <input type="file" class="form-control form-control-lg uploads" id="Foto_Avatar" name="Foto_Avatar">
                                                </div>
                                                <div class="form-group">
                                                    <div class="custom-control custom-checkbox mb-5">
                                                        <input type="checkbox" class="custom-control-input" id="customCheck1-1">
                                                        <label class="custom-control-label weight-400" for="customCheck1-1">I agree to receive notification emails</label>
                                                    </div>
                                                </div>
                                                <div class="form-group mb-0">
                                                    <button type="submit" id="Submit" class="btn btn-primary">Update Informasi</button>
                                                </div>
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection 

@section('js')

    <script>
        $(function(){
            $('.uploads').change(readURL)  
        });

        function check()
        {
            if($('#Password').val() == $('#Retype_Password').val())
                $('#Submit').attr('disabled', false);
            else 
                $('#Submit').attr('disabled', true);
        }

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