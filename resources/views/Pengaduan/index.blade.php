@extends('layouts-front.app')

@section('content')

    <!-- Slider Area Start-->
        <div class="slider-area ">
            <div class="slider-active">
                <div class="single-slider slider-height d-flex align-items-center" data-background="assets/img/hero/h1_hero.png">
                    <div class="container">
                        <div class="row d-flex align-items-center">
                            <div class="col-lg-7 col-md-9 ">
                                <div class="hero__caption">
                                    <h1 data-animation="fadeInLeft" data-delay=".4s">Pengaduan Aset<br> SMKN 5 Bandung</h1>
                                    <p data-animation="fadeInLeft" data-delay=".6s"></p>
                                    <!-- Hero-btn -->
                                    <div class="hero__btn" data-animation="fadeInLeft" data-delay=".8s">
                                        <a href="{{ url('/pengaduan/aset') }}" class="btn hero-btn">Pengaduan</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-5">
                                <div class="hero__img d-none d-lg-block" data-animation="fadeInRight" data-delay="1s">
                                    <img src="assets/img/hero/hero_right.png" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Slider Area End-->
        <!-- What We do start-->
        <div class="what-we-do we-padding">
            <div class="container">
                <!-- Section-tittle -->
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-8">
                        <div class="section-tittle text-center">
                            <h2>Pengaduan Aset Ditunjukan Untuk</h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-md-6">
                        <div class="single-do text-center mb-30">
                            <div class="do-icon">
                                <span  class="flaticon-tasks"></span>
                            </div>
                            <div class="do-caption">
                                <h4>Mengetahui aset yang rusak</h4>
                                <p>Aset yang rusak harus segera dilaporkan kepada TU Sarpras untuk ditindak lanjut!</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6">
                        <div class="single-do active text-center mb-30">
                            <div class="do-icon">
                                <span  class="flaticon-social-media-marketing"></span>
                            </div>
                            <div class="do-caption">
                                <h4>Mengganti aset yang rusak dengan aset yang baru</h4>
                                <p>Dimaksudkan untuk mengganti aset yang rusak dengan aset yang baru!</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- What We do End-->

@endsection

