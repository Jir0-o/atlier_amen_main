@extends('layouts.guest')

@section('title', 'Checkout')

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- cart top section start -->
        <section class="banner-box">
            <div class="bg-banner-box"
                style="background-image: linear-gradient( rgb(0 0 0/ 50%), rgb(0 0 0 / 50%)), url('./asset/img/webimg/port-3-gallery.jpg');">
                <h1 class="jacques text-uppercase px-4">Checkout Now</h1>
            </div>
        </section>
        <!-- cart top section end -->

        <!-- checkout content start -->
        <section class="section-gap px-4">
            <div class="row">
                <div class="col-sm-6 col-md-7 col-xxl-8">
                    <div class="bg-form-dark playfair mb-4">
                        <div class="d-flex justify-content-between align-items-end">
                            <h4 class="m-0">Contact Info</h4>
                            <small>* Required Field</small>
                        </div>
                        <div class="row">
                            <!-- <div class="col-md-12 p-2">
                                <div class="form-group mb-4">
                                    <label class="form-label" for="email">Email</label>
                                    <input class="form-control" type="email" name="email" id="email"
                                        placeholder="Delivery mail">
                                </div>
                            </div> -->
                        </div>
                        <h4>Shipping Address</h4>
                        <div class="row">
                            <div class="col-md-6 p-2">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="f_name">First Name</label>
                                    <input class="form-control" type="text" name="f_name" id="f_name"
                                        placeholder="Enter your first name">
                                </div>
                            </div>
                            <div class="col-md-6 p-2">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="l_name">Last Name</label>
                                    <input class="form-control" type="text" name="l_name" id="l_name"
                                        placeholder="Enter your last name">
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="l_name">Street Address</label>
                                    <textarea class="form-control" name="l_name" id="l_name" rows="3"
                                        placeholder="Write Your Street Information"></textarea>
                                </div>
                            </div>
                            <div class="col-md-4 p-2">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="city">City</label>
                                    <input class="form-control" type="text" name="city" id="city"
                                        placeholder="Enter your city">
                                </div>
                            </div>
                            <div class="col-md-4 p-2">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="state">State</label>
                                    <input class="form-control" type="text" name="state" id="state"
                                        placeholder="Enter your state">
                                </div>
                            </div>
                            <div class="col-md-4 p-2">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="zip">Zip\Postal Code</label>
                                    <input class="form-control" type="text" name="zip" id="zip"
                                        placeholder="Enter your zip">
                                </div>
                            </div>
                            <div class="col-md-12 p-2">
                                <div class="form-group mb-2">
                                    <label class="form-label" for="country">Country</label>
                                    <input class="form-control" type="text" name="country" id="country"
                                        placeholder="Enter your country">
                                </div>
                            </div>
                            <h4>Billing Address</h4>
                            <div class="row" id="billing_address">
                                <div class="col-md-6 p-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="f_name">First Name</label>
                                        <input class="form-control" type="text" name="f_name" id="f_name"
                                            placeholder="Enter your first name">
                                    </div>
                                </div>
                                <div class="col-md-6 p-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="l_name">Last Name</label>
                                        <input class="form-control" type="text" name="l_name" id="l_name"
                                            placeholder="Enter your last name">
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="l_name">Street Address</label>
                                        <textarea class="form-control" name="l_name" id="l_name" rows="3"
                                            placeholder="Write Your Street Information"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-4 p-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="city">City</label>
                                        <input class="form-control" type="text" name="city" id="city"
                                            placeholder="Enter your city">
                                    </div>
                                </div>
                                <div class="col-md-4 p-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="state">State</label>
                                        <input class="form-control" type="text" name="state" id="state"
                                            placeholder="Enter your state">
                                    </div>
                                </div>
                                <div class="col-md-4 p-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="zip">Zip\Postal Code</label>
                                        <input class="form-control" type="text" name="zip" id="zip"
                                            placeholder="Enter your zip">
                                    </div>
                                </div>
                                <div class="col-md-12 p-2">
                                    <div class="form-group mb-2">
                                        <label class="form-label" for="country">Country</label>
                                        <input class="form-control" type="text" name="country" id="country"
                                            placeholder="Enter your country">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="billing_form">
                                    <input type="checkbox" name="billing_form" id="billing_form" checked> 
                                    <strong class="user-select-none">Same as shipping address</strong>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6 col-md-5 col-xxl-4 cormorant">
                    <h4>Product Information</h4>
                    <div class="table-responsive">
                        <table class="w-100 align-middle">
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img class="p-1" width="65" src="./asset/img/webimg/midea-2.png"
                                                alt="Image art" loading="lazy">
                                            <h5 class="m-0">The self face portrait</h5>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="text-end">$ 400</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <img class="p-1" width="65" src="./asset/img/webimg/midea-3.png"
                                                alt="Image art" loading="lazy">
                                            <h5 class="m-0">The self face portrait</h5>
                                        </div>
                                    </td>
                                    <td>
                                        <h5 class="text-end">$ 400</h5>
                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td>
                                        <h5 class="m-0">Total</h5>
                                    </td>
                                    <td>
                                        <h5 class="text-end">$ 800</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="m-0">Shipping charge</h5>
                                    </td>
                                    <td>
                                        <h5 class="text-end">$ 20</h5>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <h5 class="m-0">Grand Total</h5>
                                    </td>
                                    <td>
                                        <h5 class="text-end">$ 820</h5>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                    <hr>
                    <input class="btn btn-dark w-100" type="submit" class="Process to pay">
                </div>
            </div>
        </section>
        <!-- checkout content end -->
    </div>
</main>
<!-- main content end -->
@endsection