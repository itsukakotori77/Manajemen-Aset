<!DOCTYPE html>
<html>
    <head>
        <!-- Basic Page Info -->
        <meta charset="utf-8">
        <title>{{ $title }}</title>

        @include('Auth.linkcss')
        
    </head>
    <body class="login-page">
        <div class="login-header box-shadow">
            <div class="container-fluid d-flex justify-content-between align-items-center">
                <div class="brand-logo">
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('assets/vendors/images/loading.png') }}" alt="">
                    </a>
                </div>
                <a href="{{ url('/komplen') }}" class="btn btn-primary btn-sm">Pengaduan</a>
            </div>
        </div>
        <div class="login-wrap d-flex align-items-center flex-wrap justify-content-center">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-lg-7">
                        <img src="{{ asset('assets/vendors/images/login-page-img.png') }}" alt="">
                    </div>
                    <div class="col-md-6 col-lg-5">
                        <div class="login-box bg-white box-shadow border-radius-10">
                            <div class="login-title">
                                <h2 class="text-center text-primary">Login Sistem Manajemen Aset SMKN 5 </h2>
                            </div>
                            <form method="POST" action="{{ url('/login') }}" autocomplete="off" id="formLogin">

                                {{ csrf_field() }}

                                <!-- Username -->
                                <div class="input-group custom">
                                    <input type="text" id="Username" name="username" required class="form-control form-control-lg" placeholder="Username">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="icon-copy dw dw-user1"></i></span>
                                    </div>
                                </div>

                                <!-- Password -->
                                <div class="input-group custom">
                                    <input type="password" id="Password" name="password" required class="form-control form-control-lg" placeholder="Password">
                                    <div class="input-group-append custom">
                                        <span class="input-group-text"><i class="dw dw-padlock1"></i></span>
                                    </div>
                                </div>

                                <!-- Remember Me -->
                                <div class="row pb-30">
                                    <div class="col-6">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="customCheck1">
                                            <label class="custom-control-label" for="customCheck1">Remember</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group mb-0">
                                            <button type="submit" class="btn btn-primary btn-lg btn-block">Masuk</button>
                                        </div>
                                    </div>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- JS -->
        @include('Auth.linkjs')
        
        <script>
            // Jquery Validator
            $("#formLogin").validate({
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('form-control-feedback');
                    element.closest('.input-group').after(error);
                },
                highlight: function (element, errorClass, validClass) {
                    // Add Class
                    $('.input-group').addClass('has-danger');
                }
            });
        </script>
        
    </body>
</html>