@extends('layouts.guest')

@section('title', 'Login')

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- login-form start -->
        <section class="login-form px-4 bg-auth-images" style="background-image: linear-gradient(rgb(0 0 0 / 50%), rgb(0 0 0 / 50%)), url('/frontend-css/img/webimg/bg-auth.jpg');">
            <div class="row align-items-center justify-content-center">
                <!-- <div class="col-md-6">
                    <div class="d-none d-md-block">
                        <img class="login-thumb" src="" alt="Art time" loading="lazy">
                    </div>
                </div> -->
                <div class="col-sm-9 col-md-7 col-xxl-5" data-aos="fade-up" data-aos-duration="2000">
                    <div class="p-4">
                        <div class="form-box-container jacques">
                            <form action="./backend/demo_1/index.html" method="post" enctype="multipart/form-data">
                                <div class="row form-box">
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="mail">Email</label>
                                        <input class="form-control" type="email" name="mail" id="mail" placeholder="Enter your registered mail">
                                    </div>
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="password">Password</label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Enter your given password">
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <p class="m-0">
                                            <label for="save">
                                                <input type="checkbox" name="save" id="save"> <span class="user-select-none">Remember Me</span>
                                            </label>
                                        </p>
                                        <p class="m-0">
                                            <strong>
                                                <a href="{{ route('frontend.password.request') }}">Forgot Password</a>
                                            </strong>
                                        </p>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <input class="btn btn-dark" type="submit" value="Login">
                                    </div>
                                    <center class="pt-2">
                                        <a class="text-decoration-underline h5" href="{{ route('frontend.register') }}">Create account</a>
                                    </center>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- login-form end -->
    </div>
</main>
<!-- main content end -->
@endsection