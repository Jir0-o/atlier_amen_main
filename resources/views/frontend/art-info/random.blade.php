@extends('layouts.guest')

@section('title', 'Artist Random')

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- page title start -->
        <section class="section-gap px-4">
            <div class="playfair page-title onload">
                <div class="d-flex gap-0 justify-content-center text-nowrap">
                    <h1>
                        R&DOM <span class="white px-2">obj</span>
                    </h1>
                </div>
            </div>
        </section>
        <!-- page title end -->
        <section class="section-gap px-4 pt-0">
            <div class="section-title-box">
                <div class="row">
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-l d-none d-sm-flex">
                            <!-- <span>.</span> -->
                        </div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-c">
                            <center>
                                <h2 class="m-0 text-uppercase jacques">random object</h2>
                            </center>
                        </div>
                    </div>
                    <div class="col-sm-4 p-0">
                        <div class="bg-shape-title title-r d-none d-sm-flex">
                            <!-- <span>.</span> -->
                        </div>
                    </div>
                </div>
            </div> 
            <div class="all-portrait pt-4 pt-md-5">
                <div class="row">
                    <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                        <div class="portrait-box">
                            <img data-aos="flip-left" data-aos-duration="2000" src="./asset/img/webimg/midea-1.png" alt="media portrait" loading="lazy">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                        <div class="portrait-box">
                            <img data-aos="flip-right" data-aos-duration="2000" src="./asset/img/webimg/midea-2.png" alt="media portrait" loading="lazy">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                        <div class="portrait-box">
                            <img data-aos="flip-left" data-aos-duration="2000" src="./asset/img/webimg/midea-3.png" alt="media portrait" loading="lazy">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                        <div class="portrait-box">
                            <img data-aos="flip-right" data-aos-duration="2000" src="./asset/img/webimg/midea-4.png" alt="media portrait" loading="lazy">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                        <div class="portrait-box">
                            <img data-aos="flip-left" data-aos-duration="2000" src="./asset/img/webimg/midea-5.png" alt="media portrait" loading="lazy">
                        </div>
                    </div>
                    <div class="col-sm-6 col-md-4 col-xxl-3 p-3">
                        <div class="portrait-box">
                            <img data-aos="flip-right" data-aos-duration="2000" src="./asset/img/webimg/midea-6.png" alt="media portrait" loading="lazy">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<!-- main content end -->
@endsection