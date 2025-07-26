@extends('layouts.guest')

<style>
.recent-img-box img {
    width: 100%;
    height: auto;
    display: block;
}

</style>

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
                    @foreach ($recentWorks as $index => $work)
                        <div class="col-sm-6 overflow-hidden p-4">
                            <a href="{{ route('frontend.works.show', $work->id) }}" title="{{ $work->name }}">
                                <div class="recent-img-box"
                                    data-aos="{{ $index % 2 == 0 ? 'zoom-out-right' : 'zoom-out-left' }}"
                                    data-aos-duration="1500">
                                    <img class="img-thumb" src="{{ asset($work->work_image_low) }}" alt="{{ $work->name }}" loading="lazy">
                                    <img class="recent-img-hover img-left" src="{{ asset($work->image_left_low) }}" alt="{{ $work->name }}" loading="lazy">
                                    <img class="recent-img-hover img-right" src="{{ asset($work->image_right_low) }}" alt="{{ $work->name }}" loading="lazy">
                                </div>
                            </a>
                        </div>
                    @endforeach
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
                        @foreach ($categories as $index => $category)
                            <div class="col-md-5">
                                <div class="portrait-box {{ $index % 2 != 0 ? 'offset-md-2 upper-box' : '' }}">
                                    <div class="col-md-2"></div>
                                    <a href="{{route('works.category', $category->slug)}}" title="{{ $category->name }}">
                                        <div class="recent-img-box aspect-vertical" data-aos="flip-left" data-aos-duration="2000">
                                            <img class="img-thumb" src="{{ asset($category->category_image) }}" alt="{{ $category->name }}" loading="lazy">
                                            <img class="recent-img-hover img-left" src="{{ asset($category->image_left) }}" alt="{{ $category->name }}" loading="lazy">
                                            <img class="recent-img-hover img-right" src="{{ asset($category->image_right) }}" alt="{{ $category->name }}" loading="lazy">
                                        </div>
                                        <h2 class="text-uppercase jacques pt-4">{{ $loop->iteration }}/ {{ $category->name }}</h2>
                                    </a>
                                </div>
                            </div>
                            @if($index % 2 != 1)
                                <div class="col-md-2"></div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </section>
            <!-- works category end -->
            <!-- feature image start -->
            <section class="cart-box section-gap px-4" data-aos="fade-up" data-aos-duration="2000">
                <div class="section-title-box mb-5">
                    <div class="row">
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-l d-none d-sm-flex"></div>
                        </div>
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-c">
                                <center>
                                    <h2 class="m-0 text-uppercase jacques">Feature Art's</h2>
                                </center>
                            </div>
                        </div>
                        <div class="col-sm-4 p-0">
                            <div class="bg-shape-title title-r d-none d-sm-flex"></div>
                        </div>
                    </div>
                </div>

                <div class="row justify-content-center">
                    @forelse($featuredWorks as $work)
                        <div class="col-sm-6 col-md-4 col-xl-3 col-xxl-2 col-01-5 p-2">
                            <a href="{{ route('frontend.works.show', $work->id) }}" 
                            class="feature-portrait-box card text-white bg-transparent" 
                            data-aos="zoom-in-down" data-aos-duration="2000"
                            title="{{ $work->name }}">
                                <div class="overflow-hidden">
                                    <img class="card-img" src="{{ $work->work_image_url }}" alt="{{ $work->name }}" loading="lazy">
                                </div>
                                <div class="card-body">
                                    <h4 class="card-title">{{ $work->name }}</h4>
                                    <p class="card-text limited-text">
                                        {{ Str::limit($work->details, 150) }}
                                    </p>
                                </div>
                            </a>
                        </div>
                    @empty
                        <p class="text-center">No featured works available.</p>
                    @endforelse
                </div>
            </section>
            <!-- feature image end -->
        </div>
    </main>
    <!-- main content end -->
@endsection