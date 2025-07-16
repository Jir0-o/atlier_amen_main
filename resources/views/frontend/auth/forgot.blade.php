@extends('layouts.guest')

@section('title', 'Forgot Password')

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- login-form start -->
        <section class="login-form px-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <div class="d-none d-md-block">
                        <img class="login-thumb" src="" alt="Art time" loading="lazy">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-4">
                        <div class="form-box-container jacques">
                            <form action="#" method="post" enctype="multipart/form-data">
                                <div class="row form-box">
                                    <div class="col-md-12 mb-4">
                                        <label class="form-label" for="mail">Email</label>
                                        <input class="form-control" type="email" name="mail" id="mail" placeholder="Enter your registered mail">
                                    </div>
                                    <div class="d-flex flex-column">
                                        <input class="btn btn-dark" type="submit" value="Submit">
                                    </div>
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