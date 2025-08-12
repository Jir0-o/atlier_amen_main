@extends('layouts.guest')

@section('title', 'Profile')

@section('content')
    <!-- main content start -->
    <main>
        <div class="content">
            <!-- profile start -->
            <div class="bg-portrait-profile">
                <section class="container py-5">
                    <div class="profile-box">
                        <div class="row m-0 overflow-hidden">
                            <div class="col-md-6 col-xl-4 col-xxl-3" data-aos="fade-up-right" data-aos-duration="2000">
                                <div class="text-center profile-img p-4">
                                    <img src="./asset/img/profile.jpg" alt="Profile Picture" loading="lazy">
                                </div>
                                <hr>
                                <div class="nav flex-column nav-pills py-3" id="v-pills-tab">
                                    <button class="nav-link text-start active" id="v-pills-home-tab"
                                        data-bs-toggle="pill" data-bs-target="#v-pills-home">
                                        Home
                                    </button>
                                    <button class="nav-link text-start" id="v-pills-order-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-order">
                                        Order List
                                    </button>
                                    <button class="nav-link text-start" id="v-pills-wishlist-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-wishlist">
                                        Wishlist
                                    </button>
                                    <button class="nav-link text-start" id="v-pills-cart-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-cart">
                                        Cart
                                    </button>
                                    <button class="nav-link text-start" id="v-pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-address">
                                        Manage Address
                                    </button>
                                    <button class="nav-link text-start" id="v-pills-settings-tab" data-bs-toggle="pill"
                                        data-bs-target="#v-pills-settings">
                                        Settings
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6 col-xl-8 col-xxl-9 border-start" data-aos="fade-up-left"
                                data-aos-duration="2000">
                                <div class="tab-content" id="v-pills-tabContent">
                                    <!-- home tab information start -->
                                    <div class="tab-pane fade show active" id="v-pills-home">
                                        <div class="p-4">
                                            <p>
                                                Hello <strong>Amen</strong>,
                                                <span>
                                                    (not Amen? <a class="text-decoration-underline"
                                                        href="./landing.html">Logout</a> )
                                                </span>
                                            </p>
                                            <p>
                                                From your account dashboard you can view your
                                                <strong id="v-pills-order-tab" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-order">
                                                    recent orders from order list
                                                </strong>, manage your
                                                <strong id="v-pills-settings-tab" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-settings">
                                                    shipping and billing addresses from manage address
                                                </strong>, and edit your
                                                <strong id="v-pills-settings-tab" data-bs-toggle="pill"
                                                    data-bs-target="#v-pills-settings">
                                                    password and account details from setting
                                                </strong>.
                                            </p>
                                        </div>
                                    </div>
                                    <!-- home tab information end -->
                                    <!-- order tab information start -->
                                    <div class="tab-pane fade" id="v-pills-order">
                                        <div class="order p-4">
                                            <div class="table-responsive">
                                                <table class="table align-middle">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-transparent text-light">#ID</th>
                                                            <th class="bg-transparent text-light">Image</th>
                                                            <th class="bg-transparent text-light">Product Name</th>
                                                            <th class="bg-transparent text-light">Quantity</th>
                                                            <th class="bg-transparent text-light">Price</th>
                                                            <th class="bg-transparent text-light">Total</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="bg-transparent text-white">
                                                                01
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                <img width="50" class="cart-product-thumb"
                                                                    src="./asset/img/webimg/draw-3.png" alt="Product 1"
                                                                    loading="lazy">
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                The Swim of Marsh-mallow
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                2
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                TK. $ 1,999
                                                            </td>
                                                            <td class="bg-transparent text-white" align="center">
                                                                TK. $ 3,998
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bg-transparent text-white">
                                                                02
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                <img width="50" class="cart-product-thumb"
                                                                    src="./asset/img/webimg/draw-1.png" alt="Product 1"
                                                                    loading="lazy">
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                The Cute Caesarean
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                1
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                TK. $ 1,000
                                                            </td>
                                                            <td class="bg-transparent text-white" align="center">
                                                                TK. $ 1,000
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="fw-bold bg-transparent text-white" colspan="2">
                                                                Total
                                                            </td>
                                                            <td class="fw-bold bg-transparent text-white" align="right"
                                                                colspan="4" align="center">
                                                                TK. $ 4,998
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- order tab information end -->
                                    <!-- wishlist tab information start -->
                                    <div class="tab-pane fade" id="v-pills-wishlist">
                                        <div class="wishlist-quick-data p-4">
                                            <div class="table-responsive">
                                                <table class="table align-middle text-center">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-transparent text-light">#SL</th>
                                                            <th class="bg-transparent text-light">Art Info</th>
                                                            <th class="bg-transparent text-light">Price</th>
                                                            <th class="bg-transparent text-light">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="bg-transparent text-light">1.</td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img class="art-thumb"
                                                                        src="./asset/img/webimg/img-cat-1.png"
                                                                        alt="Cart Item Image" loading="lazy">
                                                                    <div>
                                                                        <h6 class="mb-2">The Swim of Shade</h6>
                                                                        <p class="m-0">$ 28.55/per unit</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-end bg-transparent text-light">
                                                                $ 57.10
                                                            </td>
                                                            <td class="bg-transparent text-light">
                                                                <a href="./art_info.html" class="btn btn-primary">
                                                                    <i class="ri-eye-line"></i>
                                                                </a>
                                                                <button class="btn btn-outline-warning">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="bg-transparent text-light">2.</td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img class="art-thumb"
                                                                        src="./asset/img/webimg/img-cat-2.png"
                                                                        alt="Cart Item Image" loading="lazy">
                                                                    <div>
                                                                        <h6 class="mb-2">The Swim of Shade</h6>
                                                                        <p class="m-0">$ 28.55/per unit</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="text-end bg-transparent text-light">
                                                                $ 57.10
                                                            </td>
                                                            <td class="bg-transparent text-light">
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
                                            <div class="d-flex justify-content-end">
                                                <a href="./wishlist.html" class="btn btn-primary playfair">
                                                    View full details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- wishlist tab information end -->
                                    <!-- cart tab information start -->
                                    <div class="tab-pane fade" id="v-pills-cart">
                                        <div class="cart-box px-4 poppins mb-4">
                                            <div class="table-responsive">
                                                <table class="table align-middle text-center">
                                                    <thead>
                                                        <tr>
                                                            <th class="bg-transparent text-light">#SL</th>
                                                            <th class="bg-transparent text-light">Art Info</th>
                                                            <th class="bg-transparent text-light">QTY</th>
                                                            <th class="bg-transparent text-light">Price</th>
                                                            <th class="bg-transparent text-light">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td class="bg-transparent text-light">1.</td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img class="art-thumb"
                                                                        src="./asset/img/webimg/img-cat-1.png"
                                                                        alt="Cart Item Image" loading="lazy">
                                                                    <div>
                                                                        <h6 class="mb-2">The Swim of Shade</h6>
                                                                        <p class="m-0">$ 28.55/per unit</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex justify-content-center">
                                                                    <input class="form-control qty-number-field"
                                                                        type="number" name="qty" id="qty" min="1"
                                                                        max="99" value="2">
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
                                                            <td class="bg-transparent text-light">2.</td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    <img class="art-thumb"
                                                                        src="./asset/img/webimg/img-cat-2.png"
                                                                        alt="Cart Item Image" loading="lazy">
                                                                    <div>
                                                                        <h6 class="mb-2">The Swim of Shade</h6>
                                                                        <p class="m-0">$ 28.55/per unit</p>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex justify-content-center">
                                                                    <input class="form-control qty-number-field"
                                                                        type="number" name="qty" id="qty" min="1"
                                                                        max="99" value="2">
                                                                </div>
                                                            </td>
                                                            <td class="text-end bg-transparent text-light">
                                                                $ 57.10
                                                            </td>
                                                            <td class="bg-transparent text-light">
                                                                <button class="btn btn-outline-warning">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <a href="./cart.html" class="btn btn-primary playfair">
                                                    View full details
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- cart tab information end -->
                                    <!-- address tab information start -->
                                    <div class="tab-pane fade" id="v-pills-address">
                                        <div class="p-4">
                                            <h4>Shipping Address</h4>
                                            <div class="pt-3">
                                                <form action="#" method="post">
                                                    <div class="row mb-3">
                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="shipping-street"
                                                                class="form-label">Street</label>
                                                            <input type="text" placeholder="Enter street"
                                                                class="form-control" id="shipping-street" name="street">
                                                            <div class="invalid-feedback">
                                                                Street is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-city" class="form-label">City</label>
                                                            <input type="text" placeholder="Enter city"
                                                                class="form-control" id="shipping-city" name="city">
                                                            <div class="invalid-feedback">
                                                                City is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-state" class="form-label">State</label>
                                                            <input type="text" placeholder="Enter state"
                                                                class="form-control" id="shipping-state" name="state">
                                                            <div class="invalid-feedback">
                                                                State is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-zip" class="form-label">ZIP</label>
                                                            <input type="text" placeholder="Enter zip" value=""
                                                                class="form-control" id="shipping-zip" name="zip"
                                                                required="">
                                                            <div class="invalid-feedback">
                                                                ZIP code is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-country"
                                                                class="form-label">Country</label>
                                                            <select class="form-control" name="country" id="country">
                                                                <option selected disabled>Please select an country
                                                                </option>
                                                                <option value="aus">Australia</option>
                                                                <option value="ban">Bangladesh</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Country is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end p-3 ps-0">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                            <h4>Billing Address</h4>
                                            <div class="p-3">
                                                <form action="#" method="post">
                                                    <div class="row mb-3">
                                                        <div class="form-group col-md-4 mb-3">
                                                            <label for="shipping-street"
                                                                class="form-label">Street</label>
                                                            <input type="text" placeholder="Enter street"
                                                                class="form-control" id="shipping-street" name="street">
                                                            <div class="invalid-feedback">
                                                                Street is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-city" class="form-label">City</label>
                                                            <input type="text" placeholder="Enter city"
                                                                class="form-control" id="shipping-city" name="city">
                                                            <div class="invalid-feedback">
                                                                City is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-state" class="form-label">State</label>
                                                            <input type="text" placeholder="Enter state"
                                                                class="form-control" id="shipping-state" name="state">
                                                            <div class="invalid-feedback">
                                                                State is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-zip" class="form-label">ZIP</label>
                                                            <input type="text" placeholder="Enter zip" value=""
                                                                class="form-control" id="shipping-zip" name="zip"
                                                                required="">
                                                            <div class="invalid-feedback">
                                                                ZIP code is required.
                                                            </div>
                                                        </div>
                                                        <div class="mb-3 form-group col-md-4">
                                                            <label for="shipping-country"
                                                                class="form-label">Country</label>
                                                            <select class="form-control" name="country" id="country">
                                                                <option selected disabled>Please select an country
                                                                </option>
                                                                <option value="aus">Australia</option>
                                                                <option value="ban">Bangladesh</option>
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Country is required.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-end p-3 ps-0">
                                                        <button type="submit"
                                                            class="btn btn-primary btn-sm">Submit</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- address tab information start -->
                                </div>
                                <!-- setting tab information end -->
                                <!-- setting tab information start -->
                                <div class="tab-pane fade" id="v-pills-settings">
                                    <div class="p-4">
                                        <h4>Edit Information</h4>
                                        <form method="POST" action="#">
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="first-name">First Name</label>
                                                    <input type="text" value="Customer" class="form-control"
                                                        name="first_name" id="first-name" placeholder="Enter first name"
                                                        required="">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="last-name">Last Name</label>
                                                    <input type="text" value="User" class="form-control"
                                                        name="last_name" id="last-name" placeholder="Enter last name"
                                                        required="">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="date-of-birth">Date of Birth</label>
                                                    <input type="date" value="" class="form-control"
                                                        name="date_of_birth" id="date-of-birth"
                                                        placeholder="Enter date of birth" required="">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="username">Username</label>
                                                    <input type="text" value="customer" class="form-control"
                                                        name="username" id="username" placeholder="Enter username"
                                                        required="">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="country">Country</label>
                                                    <select class="form-control" name="country" id="country">
                                                        <option value="">Select Country</option>
                                                        <option value="AFGHANISTAN">AFGHANISTAN</option>
                                                        <option value="ALBANIA">ALBANIA</option>
                                                        <option value="ALGERIA">ALGERIA</option>
                                                        <option value="AMERICAN SAMOA">AMERICAN SAMOA</option>
                                                        <option value="ANDORRA">ANDORRA</option>
                                                        <option value="ANGOLA">ANGOLA</option>
                                                        <option value="ANGUILLA">ANGUILLA</option>
                                                    </select>
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="phone">Phone</label>
                                                    <input type="text" value="01756454346" class="form-control"
                                                        name="phone" id="phone" placeholder="Enter phone number">
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end p-3 ps-0">
                                                <button type="submit" class="btn btn-primary btn-sm hstack">
                                                    Update
                                                </button>
                                            </div>
                                        </form>
                                        <h4 class="pt-4">Change Password</h4>
                                        <form action="#">
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="current-password">Current
                                                        Password</label>
                                                    <input type="password" class="form-control" name="current_password"
                                                        id="current-password" placeholder="Enter current password"
                                                        required="">
                                                    <div class="invalid-feedback">
                                                        Current password is required.
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="new-password">New Password</label>
                                                    <input type="password" class="form-control" name="password"
                                                        id="new-password" placeholder="Enter new password" required="">
                                                    <div class="invalid-feedback">
                                                        New password is required.
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="new-confirm-password">New Confirm
                                                        Password</label>
                                                    <input type="password" class="form-control"
                                                        name="password_confirmation" id="new-confirm-password"
                                                        placeholder="Confirm Password" required="">

                                                    <div class="invalid-feedback">
                                                        Confirm password is required.
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- setting tab information end -->
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <!-- profile end -->
        </div>
    </main>
    <!-- main content end -->
@endsection