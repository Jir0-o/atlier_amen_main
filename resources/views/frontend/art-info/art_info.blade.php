@extends('layouts.guest')

@section('title', 'Art Information')

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- portrait information start -->
        <section class="section-gap px-4">
            <div class="row">
                <div class="col-sm-6 col-md-5 col-xxl-4">
                    <div class="indi-img-box" data-aos="flip-left" data-aos-duration="2000" >
                        <img src="./asset/img/webimg/port-1-gallery.jpg" alt="Gallery Preview" id="indi-img-preview" loading="lazy">
                    </div>
                    <div class="indi-img-gallery my-4">
                        <div class="row">
                            <div class="col-3 p-3">
                                <div class="active">
                                    <img src="./asset/img/webimg/port-1-gallery.jpg" alt="portrait preview" onclick="setPreviewImg(this)"
                                        loading="lazy">
                                </div>
                            </div>
                            <div class="col-3 p-3">
                                <div>
                                    <img src="./asset/img/webimg/port-2-gallery.jpg" alt="portrait preview" onclick="setPreviewImg(this)"
                                        loading="lazy">
                                </div>
                            </div>
                            <div class="col-3 p-3">
                                <div>
                                    <img src="./asset/img/webimg/port-3-gallery.jpg" alt="portrait preview" onclick="setPreviewImg(this)"
                                        loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-7 col-xxl-8">
                    <div data-aos="fade-up" data-aos-duration="2000">
                        <div class="bg-shape-title title-c">
                            <center>
                                <h2 class="m-0 text-uppercase jacques">Art information</h2>
                            </center>
                        </div>
                        <div class="art-info playfair mt-4">
                            <table>
                                <tbody>
                                    <tr>
                                        <th>Name</th>
                                        <td>: Swim in peace</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>:May 29, 2025</td>
                                    </tr>
                                    <tr>
                                        <th>Tag</th>
                                        <td>: swim, portrait, latest</td>
                                    </tr>
                                </tbody>
                            </table>
                            <h4 class="text-decoration-underline playfair fw-bold mb-3">Details: </h4>
                            <p class="poppins">
                                Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris. Morbi accumsan ipsum velit. Nam ne c tellus a odio et tincidunt auctor a ornare odio. Sedm non mauris vit ae erat consequat auctor eu in elit amet mau auctor a ornare odn o.Duis sed odio sit amet nibh vulputate cursus a sit et amet mauris.
                            </p>
                            <h4 class="text-decoration-underline playfair fw-bold mb-3">Share: </h4>
                            <div class="d-flex gap-3 flex-wrap jacques mb-4">
                                <a href="#" class="btn btn-outline-light rounded-5">
                                    <i class="ri-facebook-line"></i>
                                    Facebook
                                </a>
                                <a href="#" class="btn btn-outline-light rounded-5">
                                    <i class="ri-twitter-line"></i>
                                    Twitter
                                </a>
                                <a href="#" class="btn btn-outline-light rounded-5">
                                    <i class="ri-instagram-line"></i>
                                    Instagram
                                </a>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="btn btn-outline-light">
                                            Add to Cart
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="d-flex flex-column">
                                        <a href="#" class="btn btn-warning text-white">
                                            Buy Now
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- portrait information end -->
    </div>
</main>
<!-- main content end -->
@endsection