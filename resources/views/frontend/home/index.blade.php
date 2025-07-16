@extends('layouts.guest')

@section('title', 'Artist Prtfolio')

@section('content')
    <!-- main content start -->
    <main>
        <div class="content">
            <!-- page title start -->
            <section class="section-gap px-4">
                <div class="playfair page-title onload">
                    <div class="d-flex gap-2 justify-content-center text-nowrap">
                        <h1>
                            GET <span class="white px-2">INSPIRED</span>
                        </h1>
                    </div>
                </div>
            </section>
            <!-- page title end -->
            <!-- recent drawing start -->
            <section class="px-4">
                <div class="row">
                    <div class="col-sm-6 overflow-hidden p-4">
                        <a href="./art_info.html" title="Swim in peace">
                            <div class="recent-img-box" data-aos="zoom-out-right" data-aos-duration="1500">
                                <img class="img-thumb" src="{{ asset('frontend-css/img/webimg/img-1.png')}}" alt="Recent Image - 1" loading="lazy">
                                <img class="recent-img-hover img-left" src="{{ asset('frontend-css/img/webimg/img-1 hover-l.png')}}" alt="Recent Image - 1" loading="lazy">
                                <img class="recent-img-hover img-right" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="Recent Image - 1" loading="lazy">
                            </div>
                        </a>
                    </div>
                    <div class="col-sm-6 overflow-hidden p-4">
                        <a href="./art_info.html" title="Hand Child Drawing">
                            <div class="recent-img-box" data-aos="zoom-out-left" data-aos-duration="1500">
                                <img class="img-thumb" src="{{ asset('frontend-css/img/webimg/img-2.png')}}" alt="Recent Image - 2" loading="lazy">
                                <img class="recent-img-hover img-left" src="{{ asset('frontend-css/img/webimg/img-1 hover-l.png')}}" alt="Recent Image - 2" loading="lazy">
                                <img class="recent-img-hover img-right" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="Recent Image - 2" loading="lazy">
                            </div>
                        </a>
                    </div>
                </div>
            </section>
            <!-- recent drawing end --> 
            
            <!-- works category start -->
            <section class="px-4" data-aos="fade-up" data-aos-duration="2000">
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
                                    <h2 class="m-0 text-uppercase jacques">WORKS</h2>
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
                <div class="portrait-category pt-5">
                    <div class="row pt-5">
                        <div class="col-md-5">
                            <div class="portrait-box">
                                <a href="./drawing.html" title="Swim in peace">
                                    <div class="recent-img-box aspect-vertical" data-aos="flip-left" data-aos-duration="2000">
                                        <img class="img-thumb" src="{{ asset('frontend-css/img/webimg/img-cat-1.png')}}" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-left" src="{{ asset('frontend-css/img/webimg/img-1 hover-l.png')}}" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-right" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="Recent Image - 1" loading="lazy">
                                    </div>
                                    <h2 class="text-uppercase jacques pt-4">1/ Drawing</h2>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <div class="portrait-box upper-box">
                                <a href="./midea.html" title="Swim in peace">
                                    <div class="recent-img-box aspect-vertical" data-aos="flip-left" data-aos-duration="2000">
                                        <img class="img-thumb" src="{{ asset('frontend-css/img/webimg/img-cat-2.png')}}" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-left" src="{{ asset('frontend-css/img/webimg/img-1 hover-l.png')}}" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-right" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="Recent Image - 1" loading="lazy">
                                    </div>
                                    <h2 class="text-uppercase jacques pt-4">2/ Mixed Media</h2>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="portrait-box">
                                <a href="./painting.html" title="Swim in peace">
                                    <div class="recent-img-box aspect-vertical" data-aos="flip-left" data-aos-duration="2000">
                                        <img class="img-thumb" src="./asset/img/webimg/img-cat-3.png" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-left" src="{{ asset('frontend-css/img/webimg/img-1 hover-l.png')}}" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-right" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="Recent Image - 1" loading="lazy">
                                    </div>
                                    <h2 class="text-uppercase jacques pt-4">3/ Painting</h2>
                                </a>
                            </div>
                        </div>
                        <div class="col-md-2"></div>
                        <div class="col-md-5">
                            <div class="portrait-box upper-box">
                                <a href="./ceramic.html" title="Swim in peace">
                                    <div class="recent-img-box aspect-vertical" data-aos="flip-left" data-aos-duration="2000">
                                        <img class="img-thumb" src="./asset/img/webimg/img-cat-4.png" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-left" src="{{ asset('frontend-css/img/webimg/img-1 hover-l.png')}}" alt="Recent Image - 1" loading="lazy">
                                        <img class="recent-img-hover img-right" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="Recent Image - 1" loading="lazy">
                                    </div>
                                    <h2 class="text-uppercase jacques pt-4">4/ ceramic</h2>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- works category end -->
            <!-- feature image start -->
            <section class="cart-box section-gap px-4" data-aos="fade-up" data-aos-duration="2000">
                <div class="section-title-box mb-5">
                    <div class="row">
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-l d-none d-sm-flex">
                                <!-- <span>.</span> -->
                            </div>
                        </div>
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-c">
                                <center>
                                    <h2 class="m-0 text-uppercase jacques">Feature Art's</h2>
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
                <div class="row justify-content-center">
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="./art_info.html" class="feature-portrait-box card text-white bg-transparent" data-aos="zoom-in-down" data-aos-duration="2000">
                            <div class="overflow-hidden">
                                <img class="card-img" src="./asset/img/webimg/draw-6.png" alt="feature Img" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">The Hand Craft</h4>
                                <p class="card-text limited-text">
                                    Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                                </p>
                            </div>
                        </a>                        
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="./art_info.html" class="feature-portrait-box card text-white bg-transparent" data-aos="zoom-in-up" data-aos-duration="2000">
                            <div class="overflow-hidden">
                                <img class="card-img" src="{{ asset('frontend-css/img/webimg/img-1.png')}}" alt="feature Img" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">The Hand Craft</h4>
                                <p class="card-text limited-text">
                                    Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                                </p>
                            </div>
                        </a>                        
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="./art_info.html" class="feature-portrait-box card text-white bg-transparent" data-aos="zoom-in-down" data-aos-duration="2000">
                            <div class="overflow-hidden">
                                <img class="card-img" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="feature Img" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">The Hand Craft</h4>
                                <p class="card-text limited-text">
                                    Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                                </p>
                            </div>
                        </a>                        
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="./art_info.html" class="feature-portrait-box card text-white bg-transparent" data-aos="zoom-in-down" data-aos-duration="2000">
                            <div class="overflow-hidden">
                                <img class="card-img" src="./asset/img/webimg/draw-6.png" alt="feature Img" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">The Hand Craft</h4>
                                <p class="card-text limited-text">
                                    Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                                </p>
                            </div>
                        </a>                        
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="./art_info.html" class="feature-portrait-box card text-white bg-transparent" data-aos="zoom-in-up" data-aos-duration="2000">
                            <div class="overflow-hidden">
                                <img class="card-img" src="{{ asset('frontend-css/img/webimg/img-1.png')}}" alt="feature Img" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">The Hand Craft</h4>
                                <p class="card-text limited-text">
                                    Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                                </p>
                            </div>
                        </a>                        
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="./art_info.html" class="feature-portrait-box card text-white bg-transparent" data-aos="zoom-in-down" data-aos-duration="2000">
                            <div class="overflow-hidden">
                                <img class="card-img" src="{{ asset('frontend-css/img/webimg/img-1 hover-r.png')}}" alt="feature Img" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">The Hand Craft</h4>
                                <p class="card-text limited-text">
                                    Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                                </p>
                            </div>
                        </a>                        
                    </div>
                    <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                        <a href="./art_info.html" class="feature-portrait-box card text-white bg-transparent" data-aos="zoom-in-up" data-aos-duration="2000">
                            <div class="overflow-hidden">
                                <img class="card-img" src="./asset/img/webimg/midea-6.png" alt="feature Img" loading="lazy">
                            </div>
                            <div class="card-body">
                                <h4 class="card-title">The Hand Craft</h4>
                                <p class="card-text limited-text">
                                    Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                                </p>
                            </div>
                        </a>                        
                    </div>
                </div>
            </section>
            <!-- feature image end -->
        </div>
    </main>
    <!-- main content end -->
@endsection