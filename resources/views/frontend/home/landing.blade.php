<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artist Portfolio</title>

  <!-- plugins:css -->
    <!-- bootstrap 5.3.7 start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/css/bootstrap.min.css') }}">
    <!-- bootstrap 5.3.7 end -->
    <!-- aos animation start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/aos/dist/aos.css') }}">
    <!-- aos animation end -->
    <!-- remixicon css start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/font/remixicon/remixicon.css') }}">
    <!-- remixicon css end -->
    <!-- custom css start -->
    <link rel="stylesheet" href="{{ asset('frontend-css/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('frontend-css/css/media.css') }}">
    <!-- custom css end -->
    <!-- jquery cdn start -->
    <script src="{{ asset('frontend-css/js/jquery-3.7.1.min.js') }}"></script>
</head>

<section class="landing-animation" id="preloader">
    <div class="position-relative h-100 w-100">
        <div class="position-absolute top-0 start-0 end-0 h-35">
            <div class="leaf row p-0 h-100 z-n1 position-relative">
                <div class="col-05 ms-neg h-100" data-aos="fade-down-left" data-aos-duration="3000">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="2000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-2.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="1500">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="2500">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-2.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="2000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="3500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 ms-neg h-100" data-aos="fade-down-left" data-aos-duration="3000">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="2000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-2.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="2500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="1000">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="1500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="2000">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-2.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="2500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="3500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-2.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="2000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="3500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-3.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-2.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-right" data-aos-duration="2500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
                <div class="col-05 h-100" data-aos="fade-down-left" data-aos-duration="3000">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/leaf-1.png')}}" alt="Leaf shape" loading="lazy">
                </div>
            </div>
        </div>
        <a href="{{ route('index') }}" class="logo-fixed">
            <img data-aos="zoom-in" data-aos-delay="750" data-aos-duration="3000" src="{{ asset('frontend-css/img/logo/logo.png')}}" alt="logo" loading="lazy">
        </a>
        <div class="hand-fixed">
            <img class="prayer-hand-l" src="{{ asset('frontend-css/img/shape/prayer-l.png')}}" alt="prayer hand" loading="lazy" data-aos="zoom-in-right" data-aos-duration="3000" data-aos-delay="500">
            <img class="prayer-hand-r" src="{{ asset('frontend-css/img/shape/prayer-r.png')}}" alt="prayer hand" loading="lazy" data-aos="zoom-in-left" data-aos-duration="3000" data-aos-delay="500">
        </div>
        <div class="position-absolute bottom-0 start-0 end-0 h-50">
            <div class="flowers row p-0 h-100">
                <div class="col-1 ms-neg h-100" data-aos="fade-up-right" data-aos-duration="2500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-1.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-right" data-aos-duration="1500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-5.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-left" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-3.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-right" data-aos-duration="2500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-4.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-left" data-aos-duration="1000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-5.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-left" data-aos-duration="1500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-3.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-right" data-aos-duration="3500">
                    <img class="img-shape wave-animation vertical-rotate" src="{{ asset('frontend-css/img/shape/flower-4.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-left" data-aos-duration="2500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-2.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-right" data-aos-duration="1000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-1.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-right" data-aos-duration="3000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-1.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-left" data-aos-duration="2000">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-3.png')}}" alt="Natural Image" loading="lazy">
                </div>
                <div class="col-1 h-100" data-aos="fade-up-right" data-aos-duration="1500">
                    <img class="img-shape wave-animation" src="{{ asset('frontend-css/img/shape/flower-5.png')}}" alt="Natural Image" loading="lazy">
                </div>
            </div>
        </div>
    </div>
</section>
    <!-- all scripts -->
    <!-- custom js start -->
    <script src="{{ asset('frontend-css/js/index.js') }}"></script>
    <!-- custom js end -->
    <!-- aos animation js start -->
    <script src="{{ asset('frontend-css/aos/dist/aos.js') }}"></script>
    <!-- aos animation js end -->
    <!-- bootstrap js start -->
    <script src="{{ asset('frontend-css/js/bootstrap.bundle.min.js') }}"></script>
    <!-- bootstrap js end -->
</body>
</html>