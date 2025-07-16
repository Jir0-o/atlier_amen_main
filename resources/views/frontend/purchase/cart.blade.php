@extends('layouts.guest')

@section('title', 'Cart')

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- cart top section start -->
        <section class="banner-box">
            <div class="bg-banner-box" style="background-image: linear-gradient( rgb(0 0 0/ 50%), rgb(0 0 0 / 50%)), url('./asset/img/webimg/port-1-gallery.jpg');">
                <h1 class="jacques text-uppercase px-4">cart</h1>
            </div>
        </section>
        <!-- cart top section end -->
        
        <!-- cart section start -->
        <section class="cart-box section-gap px-4" data-aos="fade-up" data-aos-duration="2000">
            <div class="cart-all-box">
                <div class="row">
                    <!-- <div class="col-md-3 playfair">
                        <div class="box-border border border-1 border-light p-4 mb-4">
                            <h4 class="cormorant">Quick Menu</h4>
                            <hr class="opacity-100">
                            <ol type="1" class="quick-menu-list">
                                <a href="./index.html">
                                    <li>Home</li>
                                </a>
                                <a href="./about.html">
                                    <li>About</li>
                                </a>
                                <a href="./contact.html">
                                    <li>Say Hi</li>
                                </a>
                                <a href="./shop.html">
                                    <li>Shop</li>
                                </a>
                                <a href="./exhibition.html">
                                    <li>VIPS</li>
                                </a>
                            </ol>
                        </div>
                        <a href="./category.html" class="feature-box mb-4">
                            <img class="feature-banner mb-2" src="./asset/img/webimg/img-2.png" alt="Image Features" loading="lazy">
                            <h4>Feature Portrait</h4>
                        </a>
                    </div> -->
                    <div class="col-md-9">
                        <div class="cart-box px-4 poppins mb-4">
                            <div class="table-responsive">
                                <table class="table align-middle text-center">
                                    <thead>
                                        <tr>
                                            <th>#SL</th>
                                            <th>Art Info</th>
                                            <th>QTY</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>1.</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img class="art-thumb" src="./asset/img/webimg/img-cat-1.png" alt="Cart Item Image" loading="lazy">
                                                    <div>
                                                        <h6 class="mb-2">The Swim of Shade</h6>
                                                        <p class="m-0">$ 28.55/per unit</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <input class="form-control qty-number-field" type="number" name="qty" id="qty" min="1" max="99" value="2">
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                $ 57.10
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-warning">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>2.</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <img class="art-thumb" src="./asset/img/webimg/img-cat-2.png" alt="Cart Item Image" loading="lazy">
                                                    <div>
                                                        <h6 class="mb-2">The Swim of Shade</h6>
                                                        <p class="m-0">$ 28.55/per unit</p>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex justify-content-center">
                                                    <input class="form-control qty-number-field" type="number" name="qty" id="qty" min="1" max="99" value="2">
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                $ 57.10
                                            </td>
                                            <td>
                                                <button class="btn btn-outline-warning">
                                                    <i class="ri-delete-bin-line"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 cormorant">
                        <div class="box-border border border-1 border-light p-4 mb-4">
                            <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                <p class="m-0"><span class="total_qty">2</span> Item</p>
                                <strong class="poppins">$ 114.20</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                <p class="m-0">Shipping</p>
                                <strong class="poppins">$ 10.00</strong>
                            </div>
                            <div class="d-flex justify-content-between align-items-center gap-2 flex-wrap">
                                <p class="m-0">Total</p>
                                <strong class="poppins">$ 124.20</strong>
                            </div>
                            <a href="./checkout.html" class="btn btn-outline-light w-100 rounded-0 mt-3">
                                Process to checkout
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- cart section end -->
        <!-- feature image start -->
        <section class="cart-box section-gap pt-0 px-4" data-aos="fade-up" data-aos-duration="2000">
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
                            <img class="card-img" src="./asset/img/webimg/img-1.png" alt="feature Img" loading="lazy">
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
                            <img class="card-img" src="./asset/img/webimg/img-1 hover-r.png" alt="feature Img" loading="lazy">
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
                            <img class="card-img" src="./asset/img/webimg/img-1.png" alt="feature Img" loading="lazy">
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
                            <img class="card-img" src="./asset/img/webimg/img-1 hover-r.png" alt="feature Img" loading="lazy">
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