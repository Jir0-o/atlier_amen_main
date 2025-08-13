
@extends('layouts.guest')

@section('title', 'About')

@section('content')
<!-- main content start -->
<main>
<div class="content">
    <!-- about me start -->
    <section class="px-4" data-aos="fade-up" data-aos-duration="2000">
        <div class="artist-profile pt-md-5">
            <div class="row align-items-center">
                <div class="col-md-5 col-sm-6">
                    <img class="w-100 mb-4" src="{{ $about->image_path ? asset($about->image_path) : 'https://via.placeholder.com/300x200' }}" alt="Artist Profile" loading="lazy">
                </div>
                <div class="col-md-7 col-sm-6">
                    <h2 class="cormorant m-0">{{$about->title}}</h2>
                    <div class="rich-text jacques">
                        {!! $about->body ?? '' !!}
                    </div>
                    <a class="btn btn-dark fs-4 cormorant" href="{{route('contact')}}">SAY HI</a>
                </div>
            </div>
        </div>
        {{-- <center class="container">
            <div class="section-title-icon d-none d-md-flex row align-items-center justify-content-center">
                <div class="col-md-4">
                    <div class="d-flex justify-content-end">
                        <img class="title-icon-brush" src="{{ asset('frontend-css/img/shape/brush-l.png')}}" alt="brush icon left" loading="lazy">
                    </div>
                </div>
                <div class="col-md-1">
                    <img class="w-100" src="{{ asset('frontend-css/img/shape/king-plate.png')}}" alt="Color Plate" loading="lazy">
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-start">
                        <img class="title-icon-brush" src="{{ asset('frontend-css/img/shape/brush-r.png')}}" alt="brush icon right" loading="lazy">
                    </div>
                </div>
            </div>
        </center> --}}
    </section>
    <!-- about me end -->
</div>
</main>
<!-- main content end -->
@endsection