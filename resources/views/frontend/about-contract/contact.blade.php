@extends('layouts.guest')

@section('title', 'Contact Us')

@section('content')

<!-- main content start -->
<main>
    <div class="content">
        <!-- contact content start -->
        <section class="contact-form">
            <div class="row p-0 m-0">
                <div class="col-sm-6 col-md-5 p-0 bg-l" style="background-image: linear-gradient( rgb(0 0 0 / 50%), rgb( 0 0 0 / 50%)), url('./asset/img/webimg/bg-contact.jpg');">
                    <div class="d-flex justify-content-center align-items-center flex-column h-100">
                        <center data-aos="zoom-out" data-aos-duration="2000">
                            <img class="contact-profile mb-3" src="./asset/img/webimg/img-cat-1.png" alt="Profile of artist">
                            <blockquote class="cormorant">
                                <q>
                                    This was a blockquote, 
                                    <br>
                                    so the user should add a poem in there.
                                </q>
                            </blockquote>
                        </center>
                    </div>
                </div>
                <div class="col-sm-6 col-md-7 p-0 bg-r">
                    <div class="form-box p-4 overflow-hidden">
                        <form action="#" method="post" class="row" data-aos="fade-down-left" data-aos-delay="1000" data-aos-duration="2000">
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="name">Full Name: <span class="text-danger">*</span></label>
                                <input class="form-control" name="name" type="text" id="name" placeholder="Write your full name..." required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="email">Email: <span class="text-danger">*</span></label>
                                <input class="form-control" name="email" type="mail" id="email" placeholder="Write your full name..." required>
                            </div>
                            <div class="col-md-12 mb-3">
                                <label class="form-label" for="number">Contact: </label>
                                <input class="form-control" name="number" type="number" id="number" placeholder="Write your full name...">
                            </div>
                            <div class="col-md-12 mb-4">
                                <label class="form-label" for="message">Message: </label>
                                <textarea class="form-control" name="message" id="message" rows="3" placeholder="Write your full name..."></textarea>
                            </div>
                            <div class="col-md-4">
                                <div class="d-flex flex-column">
                                    <input type="submit" class="btn btn-outline-light" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
        <!-- contact content end -->
    </div>
</main>
<!-- main content end -->
@endsection