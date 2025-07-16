
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
                    <img class="w-100 mb-4" src="./asset/img/webimg/profile.png" alt="Artist Profile" loading="lazy">
                </div>
                <div class="col-md-7 col-sm-6">
                    <h2 class="cormorant m-0">About Me</h2>
                    <h5 class="cormorant mb-4">I am Atelier Amen,</h5>
                    <div class="rich-text jacques">
                        <p>
                            I'm a freelance graphic designer and illustrator based in Winnipeg, Canada, with over eight years of professional experience in the creative industry. My work has spanned multiple design agencies, where I specialized in crafting compelling visual narratives through illustration, branding, and identity design. I’m passionate about building brands that not only look beautiful but also communicate meaning and purpose with clarity and style.
                        </p>
                        <p>
                            My work has spanned multiple design agencies, where I specialized in crafting compelling visual narratives through illustration, branding, and identity design. I’m passionate about building brands that not only look beautiful but also communicate meaning and purpose with clarity and style.
                        </p>
                    </div>
                    <a class="btn btn-dark fs-4 cormorant" href="./contact.html">SAY HI</a>
                </div>
            </div>
        </div>
        <center class="container">
            <div class="section-title-icon d-none d-md-flex row align-items-center justify-content-center">
                <div class="col-md-4">
                    <div class="d-flex justify-content-end">
                        <img class="title-icon-brush" src="./asset/img/shape/brush-l.png" alt="brush icon left" loading="lazy">
                    </div>
                </div>
                <div class="col-md-1">
                    <img class="w-100" src="./asset/img/shape/king-plate.png" alt="Color Plate" loading="lazy">
                </div>
                <div class="col-md-4">
                    <div class="d-flex justify-content-start">
                        <img class="title-icon-brush" src="./asset/img/shape/brush-r.png" alt="brush icon right" loading="lazy">
                    </div>
                </div>
            </div>
        </center>
    </section>
    <!-- about me end -->
</div>
</main>
<!-- main content end -->
@endsection