@extends('layouts.guest')

@section('title', 'Wishlist')

@section('content')
    <!-- main content start -->
    <main>
        <div class="content">
            <!-- wishlist top section start -->
            <section class="banner-box">
                <div class="bg-banner-box"
                    style="background-image: linear-gradient( rgb(0 0 0/ 50%), rgb(0 0 0 / 50%)), url('./asset/img/webimg/port-1-gallery.jpg');">
                    <h1 class="jacques text-uppercase px-4">Wishlist</h1>
                </div>
            </section>
            <!-- wishlist top section end -->

            <!-- wishlist table start -->
            <section class="pt-4" data-aos="fade-up" data-aos-duration="2000">
                <div class="cart-box wishlist-cart px-4 poppins mb-4">
                    <div class="table-responsive">
                        <table class="table align-middle text-center">
                            <thead>
                                <tr>
                                    <th>#SL</th>
                                    <th>Art Info</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1.</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img class="art-thumb" src="./asset/img/webimg/img-cat-1.png"
                                                alt="Cart Item Image" loading="lazy">
                                            <div>
                                                <h6 class="mb-2">The Swim of Shade</h6>
                                                <p class="m-0">$ 28.55/per unit</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        $ 57.10
                                    </td>
                                    <td>
                                        <a href="./art_info.html" class="btn btn-primary">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <button class="btn btn-outline-warning">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2.</td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img class="art-thumb" src="./asset/img/webimg/img-cat-2.png"
                                                alt="Cart Item Image" loading="lazy">
                                            <div>
                                                <h6 class="mb-2">The Swim of Shade</h6>
                                                <p class="m-0">$ 28.55/per unit</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-end">
                                        $ 57.10
                                    </td>
                                    <td>
                                        <a href="./art_info.html" class="btn btn-primary">
                                            <i class="ri-eye-line"></i>
                                        </a>
                                        <button class="btn btn-outline-warning">
                                            <i class="ri-delete-bin-line"></i>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>
            <!-- wishlist table end -->
        </div>
    </main>
    <!-- main content end -->
@endsection