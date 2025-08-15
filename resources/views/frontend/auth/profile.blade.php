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
                                    <img src="{{ asset('frontend-css/img/profile.jpg')}}" alt="Profile Picture" loading="lazy">
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
                                                Hello <strong>{{ Auth::user()->name }}</strong>,
                                                <span>
                                                    (not {{ Auth::user()->name }} <a class="text-decoration-underline"
                                                        href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Logout</a> )
                                                    <form id="logout-form" action="{{ route('logout') }}"
                                                        method="POST" style="display: none;">
                                                        @csrf
                                                    </form>
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
                                                            <th class="bg-transparent text-light">Status</th>
                                                            <th class="bg-transparent text-light">Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                    @forelse($order as $i => $o)
                                                        @php
                                                            $firstItem = $o->items->first();
                                                            $thumb = optional($firstItem?->work)->work_image_low
                                                                ?? optional($firstItem?->work)->work_image
                                                                ?? null;

                                                            // Build "Name (Variant) × Qty" lines
                                                            $itemsHtml = $o->items->map(function($it) {
                                                                $name = $it->work->name ?? 'Unnamed';
                                                                $variant = $it->variant_text
                                                                    ?? optional($it->workVariant)->name
                                                                    ?? null;
                                                                $label = e($name) . ($variant ? ' (' . e($variant) . ')' : '');
                                                                return $label . ' × ' . (int) $it->quantity;
                                                            })->implode('<br>');
                                                        @endphp

                                                        <tr>
                                                            <td class="bg-transparent text-white">
                                                                {{ $order->firstItem() + $i }}.
                                                            </td>

                                                            <td class="bg-transparent text-white">
                                                                <div class="position-relative d-inline-block">
                                                                    <img width="50" class="cart-product-thumb"
                                                                        src="{{ $thumb ? asset($thumb) : asset('images/no-image.png') }}"
                                                                        alt="Order {{ $o->id }} First Item" loading="lazy">
                                                                    @if($o->items->count() > 1)
                                                                        <span class="badge bg-secondary position-absolute top-0 start-100 translate-middle">
                                                                            +{{ $o->items->count() - 1 }}
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </td>

                                                            {{-- Product Name column shows all items with variants --}}
                                                            <td class="bg-transparent text-white text-start">
                                                                {!! $itemsHtml !!}
                                                            </td>

                                                            <td class="bg-transparent text-white">
                                                                {{ (int) $o->total_qty }}
                                                            </td>

                                                            {{-- Per-row price: show Subtotal and Grand Total (shipping included) --}}
                                                            <td class="bg-transparent text-white">
                                                                TK. {{ number_format((float) $o->subtotal, 2) }}
                                                            </td>
                                                            <td class="bg-transparent text-white" align="center">
                                                                TK. {{ number_format((float) $o->grand_total, 2) }}
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                @if($o->status === 'pending')
                                                                    <span class="badge bg-warning">Pending</span>
                                                                @elseif($o->status === 'completed')
                                                                    <span class="badge bg-success">Completed</span>
                                                                @elseif($o->status === 'cancelled')
                                                                    <span class="badge bg-danger">Cancelled</span>
                                                                @else
                                                                    <span class="badge bg-secondary">{{ ucfirst($o->status) }}</span>
                                                                @endif
                                                            </td>
                                                            <td class="bg-transparent text-white">
                                                                <button
                                                                    type="button"
                                                                    class="btn btn-sm btn-primary btn-view-order"
                                                                    data-order-id="{{ $o->id }}"
                                                                    data-url="{{ route('account.orders.show', $o->id) }}"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#orderDetailsModal">
                                                                    <i class="ri-eye-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="6" class="text-center text-muted">No recent orders found.</td>
                                                        </tr>
                                                    @endforelse
                                                    </tbody>
                                                </table>
                                                <div class="d-flex justify-content-end mt-3">
                                                    {{ $order->appends(['tab' => 'order'])->onEachSide(1)->links() }}
                                                </div>
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
                                                    <tbody id="wishlist-body">
                                                        @forelse($wishlist as $i => $w)
                                                        <tr>
                                                            <td class="bg-transparent text-light">{{ $i+1 }}.</td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @php $img = $w->work->work_image_low ?? $w->work->work_image ?? $w->work_image_low; @endphp
                                                                    <img class="art-thumb" src="{{ $img ? asset($img) : asset('images/no-image.png') }}" alt="">
                                                                    <div>
                                                                        <h6 class="mb-2">{{ $w->work->name ?? $w->work_name ?? 'Artwork' }}</h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="bg-transparent text-light">
                                                                @if($w->work->variants->isNotEmpty())
                                                                    TK. {{ number_format((float) $w->work->variants->min('price'), 2) }}
                                                                @else
                                                                    N/A
                                                                @endif
                                                            </td>
                                                            <td class="bg-transparent text-light">
                                                                <button class="btn btn-outline-warning btn-remove-wishlist"
                                                                        data-remove-url="{{ route('wishlist.remove', $w->id) }}"
                                                                        title="Remove">
                                                                <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                            <tr>
                                                                <td colspan="4" class="text-center text-muted">No items in wishlist.</td>
                                                            </tr>
                                                        @endforelse
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('wishlist') }}" class="btn btn-primary playfair">
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
                                                    <tbody id="cart-items-body">
                                                        <tr>
                                                        @forelse($cart as $i => $c)
                                                        <tr>
                                                            <td class="bg-transparent text-light">{{ $i+1 }}.</td>
                                                            <td class="bg-transparent text-light">
                                                                <div class="d-flex align-items-center gap-2">
                                                                    @php $img = $c->work->work_image_low ?? $c->work->work_image ?? $c->work_image_low; @endphp
                                                                    <img class="art-thumb" src="{{ $img ? asset($img) : asset('images/no-image.png') }}" alt="">
                                                                    <div>
                                                                        <h6 class="mb-2">{{ $c->work->name ?? $c->work_name ?? 'Artwork' }}</h6>
                                                                        @if($c->variant_text)
                                                                            <small class="text-light d-block">Variant: {{ $c->variant_text }}</small>
                                                                        @elseif(!empty($c->workVariant?->name))
                                                                            <small class="text-light d-block">Variant: {{ $c->workVariant->name }}</small>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </td>
                                                            <td class="bg-transparent text-light">{{ (int) $c->quantity }}</td>
                                                            <td class="text-end bg-transparent text-light">
                                                                @php $line = (float)($c->unit_price ?? 0) * (int)$c->quantity; @endphp
                                                                TK. {{ number_format($line, 2) }}
                                                            </td>
                                                            <td class="bg-transparent text-light">
                                                                <button class="btn btn-outline-warning btn-remove-cart"
                                                                        data-remove-url="{{ route('cart.destroy', $c->id) }}"
                                                                        title="Remove">
                                                                    <i class="ri-delete-bin-line"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                        @empty
                                                        <tr><td colspan="5" class="text-center text-muted">Your cart is empty.</td></tr>
                                                        @endforelse
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="d-flex justify-content-end">
                                                <a href="{{ route('cart') }}" class="btn btn-primary playfair">
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
                                                {{-- Shipping Address --}}
                                                <form action="{{ route('account.address.shipping.upsert') }}" method="post" novalidate>
                                                @csrf
                                                <div class="row mb-3">
                                                    <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="shipping-street">Street</label>
                                                    <input type="text" id="shipping-street" name="street" class="form-control"
                                                            value="{{ old('street', $user->shippingAddress->street ?? '') }}"
                                                            placeholder="Enter street">
                                                    </div>
                                                    <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="shipping-city">City</label>
                                                    <input type="text" id="shipping-city" name="city" class="form-control"
                                                            value="{{ old('city', $user->shippingAddress->city ?? '') }}"
                                                            placeholder="Enter city">
                                                    </div>
                                                    <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="shipping-state">State</label>
                                                    <input type="text" id="shipping-state" name="state" class="form-control"
                                                            value="{{ old('state', $user->shippingAddress->state ?? '') }}"
                                                            placeholder="Enter state">
                                                    </div>
                                                    <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="shipping-zip">ZIP</label>
                                                    <input type="text" id="shipping-zip" name="zip" class="form-control"
                                                            value="{{ old('zip', $user->shippingAddress->zip ?? '') }}"
                                                            placeholder="Enter zip">
                                                    </div>
                                                    <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="shipping-country">Country</label>
                                                    <select id="shipping-country" name="country" class="form-control">
                                                        @php $shipCountry = old('country', $user->shippingAddress->country ?? ''); @endphp
                                                        <option disabled {{ $shipCountry ? '' : 'selected' }}>Please select a country</option>
                                                        <option value="Australia"  {{ $shipCountry==='Australia' ? 'selected':'' }}>Australia</option>
                                                        <option value="Bangladesh" {{ $shipCountry==='Bangladesh' ? 'selected':'' }}>Bangladesh</option>
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="d-flex justify-content-end p-3 ps-0">
                                                    <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                                                </div>
                                                </form>
                                            </div>
                                            <h4>Billing Address</h4>
                                            <div class="p-3">
                                            {{-- Billing Address --}}
                                            <form action="{{ route('account.address.billing.upsert') }}" method="post" novalidate>
                                            @csrf
                                            <div class="row mb-3">
                                                <div class="form-group col-md-4 mb-3">
                                                <label class="form-label" for="billing-street">Street</label>
                                                <input type="text" id="billing-street" name="street" class="form-control"
                                                        value="{{ old('street', $user->billingAddress->street ?? '') }}"
                                                        placeholder="Enter street">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                <label class="form-label" for="billing-city">City</label>
                                                <input type="text" id="billing-city" name="city" class="form-control"
                                                        value="{{ old('city', $user->billingAddress->city ?? '') }}"
                                                        placeholder="Enter city">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                <label class="form-label" for="billing-state">State</label>
                                                <input type="text" id="billing-state" name="state" class="form-control"
                                                        value="{{ old('state', $user->billingAddress->state ?? '') }}"
                                                        placeholder="Enter state">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                <label class="form-label" for="billing-zip">ZIP</label>
                                                <input type="text" id="billing-zip" name="zip" class="form-control"
                                                        value="{{ old('zip', $user->billingAddress->zip ?? '') }}"
                                                        placeholder="Enter zip">
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                <label class="form-label" for="billing-country">Country</label>
                                                <select id="billing-country" name="country" class="form-control">
                                                    @php $billCountry = old('country', $user->billingAddress->country ?? ''); @endphp
                                                    <option disabled {{ $billCountry ? '' : 'selected' }}>Please select a country</option>
                                                    <option value="Australia"  {{ $billCountry==='Australia' ? 'selected':'' }}>Australia</option>
                                                    <option value="Bangladesh" {{ $billCountry==='Bangladesh' ? 'selected':'' }}>Bangladesh</option>
                                                </select>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end p-3 ps-0">
                                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
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
                                        <form method="POST" action="{{ route('account.settings.profile') }}">
                                        @csrf
                                        <div class="row">
                                            <div class="form-group col-md-4 mb-3">
                                            <label class="form-label" for="first-name">First Name</label>
                                            <input type="text" class="form-control" id="first-name" name="first_name"
                                                    value="{{ old('first_name', $user->first_name) }}" required>
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                            <label class="form-label" for="last-name">Last Name</label>
                                            <input type="text" class="form-control" id="last-name" name="last_name"
                                                    value="{{ old('last_name', $user->last_name) }}" required>
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                            <label class="form-label" for="date-of-birth">Date of Birth</label>
                                            <input type="date" class="form-control" id="date-of-birth" name="date_of_birth"
                                                    value="{{ old('date_of_birth', optional($user->date_of_birth)->format('Y-m-d')) }}">
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                            <label class="form-label" for="username">Username</label>
                                            <input type="text" class="form-control" id="username" name="username"
                                                    value="{{ old('username', $user->username) }}">
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                            <label class="form-label" for="country">Country</label>
                                            <select class="form-control" id="country" name="country">
                                                @php $country = old('country', $user->country); @endphp
                                                <option value="">Select Country</option>
                                                <option value="AFGHANISTAN" {{ $country==='AFGHANISTAN'?'selected':'' }}>AFGHANISTAN</option>
                                                <option value="ALBANIA"     {{ $country==='ALBANIA'?'selected':'' }}>ALBANIA</option>
                                                <option value="ALGERIA"     {{ $country==='ALGERIA'?'selected':'' }}>ALGERIA</option>
                                                <option value="AMERICAN SAMOA" {{ $country==='AMERICAN SAMOA'?'selected':'' }}>AMERICAN SAMOA</option>
                                                <option value="ANDORRA"     {{ $country==='ANDORRA'?'selected':'' }}>ANDORRA</option>
                                                <option value="ANGOLA"      {{ $country==='ANGOLA'?'selected':'' }}>ANGOLA</option>
                                                <option value="ANGUILLA"    {{ $country==='ANGUILLA'?'selected':'' }}>ANGUILLA</option>
                                                {{-- add your full list as needed --}}
                                            </select>
                                            </div>
                                            <div class="form-group col-md-4 mb-3">
                                            <label class="form-label" for="phone">Phone</label>
                                            <input type="text" class="form-control" id="phone" name="phone"
                                                    value="{{ old('phone', $user->phone) }}">
                                            </div>
                                        </div>
                                        <div class="d-flex justify-content-end p-3 ps-0">
                                            <button type="submit" class="btn btn-primary btn-sm hstack">Update</button>
                                        </div>
                                        </form>
                                        <h4 class="pt-4">Change Password</h4>
                                        <form method="POST" action="{{ route('account.settings.password') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-3 position-relative">
                                                    <label class="form-label" for="current-password">Current Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="current-password" name="current_password" required>
                                                        <span class="input-group-text toggle-password" data-target="#current-password" style="cursor:pointer;">
                                                            <i class="ri-eye-off-line"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 position-relative">
                                                    <label class="form-label" for="new-password">New Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="new-password" name="password" required>
                                                        <span class="input-group-text toggle-password" data-target="#new-password" style="cursor:pointer;">
                                                            <i class="ri-eye-off-line"></i>
                                                        </span>
                                                    </div>
                                                </div>

                                                <div class="form-group col-md-4 mb-3 position-relative">
                                                    <label class="form-label" for="new-confirm-password">New Confirm Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="new-confirm-password" name="password_confirmation" required>
                                                        <span class="input-group-text toggle-password" data-target="#new-confirm-password" style="cursor:pointer;">
                                                            <i class="ri-eye-off-line"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end p-3 ps-0">
                                                <button type="submit" class="btn btn-primary btn-sm hstack">Update</button>
                                            </div>
                                        </form>
                                        {{-- change email address --}}
                                        <h4 class="pt-4">Change Email Address</h4>
                                        <form method="POST" action="{{ route('account.settings.email') }}">
                                            @csrf
                                            <div class="row">
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="email">New Email Address</label>
                                                    <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
                                                </div>
                                                <div class="form-group col-md-4 mb-3">
                                                    <label class="form-label" for="email-password">Current Password</label>
                                                    <div class="input-group">
                                                        <input type="password" class="form-control" id="email-password" name="current_password" required>
                                                        <span class="input-group-text toggle-password" data-target="#email-password" style="cursor:pointer;">
                                                            <i class="ri-eye-off-line"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex justify-content-end p-3 ps-0">
                                                <button type="submit" class="btn btn-primary btn-sm hstack">Update</button>
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

    <!-- Order Details Modal -->
<div class="modal fade" id="orderDetailsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content bg-dark text-light">
      <div class="modal-header">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body">
        <!-- Loading state -->
        <div id="order-modal-loading" class="py-5 text-center d-none">
          <div class="spinner-border" role="status"></div>
          <div class="mt-3">Loading order...</div>
        </div>

        <!-- Error state -->
        <div id="order-modal-error" class="alert alert-danger d-none"></div>

        <!-- Content -->
        <div id="order-modal-content" class="d-none">
          <div class="row mb-3">
            <div class="col-md-6">
              <h6 class="mb-2">Order Info</h6>
              <div id="order-info"></div>
            </div>
            <div class="col-md-6">
              <h6 class="mb-2">Shipping</h6>
              <div id="order-shipping"></div>
              <h6 class="mt-3 mb-2">Billing</h6>
              <div id="order-billing"></div>
            </div>
          </div>

          <div class="table-responsive">
            <table class="table align-middle text-center">
              <thead>
                <tr>
                  <th class="bg-transparent text-light">Image</th>
                  <th class="bg-transparent text-light text-start">Product & Variant</th>
                  <th class="bg-transparent text-light">Qty</th>
                  <th class="bg-transparent text-light">Unit Price</th>
                  <th class="bg-transparent text-light">Line Total</th>
                </tr>
              </thead>
              <tbody id="order-items-body"></tbody>
              <tfoot>
                <tr>
                  <td colspan="3"></td>
                  <td class="bg-transparent text-light text-end">Subtotal</td>
                  <td id="order-subtotal" class="bg-transparent text-light text-end"></td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                  <td class="bg-transparent text-light text-end">Shipping</td>
                  <td id="order-shipping-charge" class="bg-transparent text-light text-end"></td>
                </tr>
                <tr>
                  <td colspan="3"></td>
                  <td class="bg-transparent text-light text-end fw-bold">Grand Total</td>
                  <td id="order-grand-total" class="bg-transparent text-light text-end fw-bold"></td>
                </tr>
              </tfoot>
            </table>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-outline-light" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

    <!-- main content end -->
<script>
//load jquery
  document.write('<script src="https://code.jquery.com/jquery-3.7.1.min.js"><\/script>');
    //load bootstrap js
    document.write('<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"><\/script>');
</script>

<script>
(function($){
  function money(n){ 
    n = Number(n || 0);
    return 'TK. ' + n.toFixed(2);
  }

  function safe(text){
    return $('<div>').text(text ?? '').html();
  }

  function addressBlock(addr){
    if(!addr) return '';
    let parts = [
      safe(addr.name),
      safe(addr.address),
      [safe(addr.city), safe(addr.state)].filter(Boolean).join(', '),
      [safe(addr.zip), safe(addr.country)].filter(Boolean).join(', ')
    ].filter(Boolean);
    return parts.join('<br>');
  }

  function renderItems(items){
    if(!items || !items.length){
      return '<tr><td colspan="5" class="text-center text-light">No items.</td></tr>';
    }

    return items.map(function(it){
      const variantLine = it.variant ? `<small class="text-light d-block">Variant: ${safe(it.variant)}</small>` : '';
      return `
        <tr>
          <td class="bg-transparent text-light">
            <img src="${safe(it.image)}" alt="${safe(it.name)}" class="cart-product-thumb" width="60" loading="lazy">
          </td>
          <td class="bg-transparent text-light text-start">
            <div class="fw-semibold">${safe(it.name)}</div>
            ${variantLine}
          </td>
          <td class="bg-transparent text-light">${it.quantity}</td>
          <td class="bg-transparent text-light text-end">${money(it.unit_price)}</td>
          <td class="bg-transparent text-light text-end">${money(it.line_total)}</td>
        </tr>`;
    }).join('');
  }

  $(document).on('click', '.btn-view-order', function(){
    var url = $(this).data('url');

    // Reset states
    $('#order-modal-error').addClass('d-none').empty();
    $('#order-modal-content').addClass('d-none');
    $('#order-modal-loading').removeClass('d-none');

    $.ajax({
      url: url,
      type: 'GET',
      dataType: 'json'
    })
    .done(function(res){
      if(!res || !res.success){
        $('#order-modal-error').removeClass('d-none').text('Failed to load order.');
        return;
      }

      // Fill order info blocks
      const o = res.order || {};
      $('#order-info').html(`
        <div>Order ID: <strong>#${safe(o.id)}</strong></div>
        <div>Status: <span class="badge bg-info">${safe(o.status)}</span></div>
        <div>Created: ${safe(o.created_at)}</div>
        <div>Total Qty: ${safe(o.total_qty)}</div>
      `);

      $('#order-shipping').html(addressBlock(o.shipping));
      $('#order-billing').html(addressBlock(o.billing));

      // Items
      $('#order-items-body').html(renderItems(res.items || []));

      // Totals
      $('#order-subtotal').text(money(o.subtotal));
      $('#order-shipping-charge').text(money(o.shipping_charge));
      $('#order-grand-total').text(money(o.grand_total));

      // Show content
      $('#order-modal-loading').addClass('d-none');
      $('#order-modal-content').removeClass('d-none');
    })
    .fail(function(xhr){
      let msg = 'Error loading order.';
      if(xhr?.responseJSON?.message){ msg = xhr.responseJSON.message; }
      $('#order-modal-loading').addClass('d-none');
      $('#order-modal-error').removeClass('d-none').text(msg);
    });
  });

    const p = new URLSearchParams(window.location.search);
    const tab = p.get('tab');
    if (tab) {
        const trigger = document.querySelector(`[data-bs-target="#v-pills-${tab}"]`);
        if (trigger) new bootstrap.Tab(trigger).show();
    }

    function csrfHeader(){ return {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}; }
    function toastOk(m){ if (window.Swal) Swal.fire({icon:'success',title:m,timer:1200,showConfirmButton:false}); else alert(m); }
    function toastErr(m){ if (window.Swal) Swal.fire({icon:'error',title:m,timer:1500,showConfirmButton:false}); else alert(m); }

    $('#wishlist-body').on('click', '.btn-remove-wishlist', function(e){
    e.preventDefault();
    const $btn = $(this);
    const url  = $btn.data('remove-url');
    const $tr  = $btn.closest('tr');

    $btn.prop('disabled', true);

    function handleSuccess(resp){
        if (resp?.status === 'success') {
        $('#mini-wishlist-count').text(resp.count ?? 0);
        $tr.remove();
        toastOk('Removed from wishlist');
        if (!$('#wishlist-body tr').length) {
            $('#wishlist-body').html('<tr><td colspan="4" class="text-center text-muted">No items in wishlist.</td></tr>');
        }
        } else {
        toastErr(resp?.message || 'Failed to remove');
        }
    }

    function handleFail(xhr){
        // Log for debugging
        console.warn('Wishlist delete failed:', xhr.status, xhr.responseText);
        const msg = xhr?.responseJSON?.message || `Failed (${xhr.status})`;
        toastErr(msg);
    }

    $.ajax({ url: url, method: 'DELETE', headers: csrfHeader() })
        .done(handleSuccess)
        .fail(function(xhr){
        if (xhr.status === 405) {
            // Fallback: POST + _method=DELETE (some servers block DELETE)
            $.ajax({
            url: url,
            method: 'POST',
            headers: csrfHeader(),
            data: { _method: 'DELETE' }
            }).done(handleSuccess).fail(handleFail).always(()=> $btn.prop('disabled', false));
        } else {
            handleFail(xhr);
            $btn.prop('disabled', false);
        }
        })
        .always(function(){ $btn.prop('disabled', false);});
    });

    //remove cart item
    $('#cart-items-body').on('click', '.btn-remove-cart', function(e){
    e.preventDefault();
    const $btn = $(this);
    const url  = $btn.data('remove-url');
    const $tr  = $btn.closest('tr');

    $btn.prop('disabled', true);

    $.ajax({ url: url, method: 'DELETE', headers: csrfHeader() })
        .done(function(resp){
        if (resp?.status === 'success') {
            $('#mini-cart-count').text(resp.count ?? 0);
            $tr.remove();
            toastOk('Removed from cart');
            if (!$('#cart-items-body tr').length) {
            $('#cart-items-body').html('<tr><td colspan="4" class="text-center text-muted">No items in cart.</td></tr>');
            }
        } else {
            toastErr(resp?.message || 'Failed to remove');
        }
        })
        .fail(function(xhr){
        const msg = xhr?.responseJSON?.message || `Failed (${xhr.status})`;
        toastErr(msg);
        })
        .always(function(){ $btn.prop('disabled', false);});
    });

   document.addEventListener('click', function (e) {
        if (e.target.closest('.toggle-password')) {
            let toggle = e.target.closest('.toggle-password');
            let targetInput = document.querySelector(toggle.getAttribute('data-target'));
            let icon = toggle.querySelector('i');

            if (targetInput.type === 'password') {
                targetInput.type = 'text';
                icon.classList.remove('ri-eye-off-line');
                icon.classList.add('ri-eye-line');
            } else {
                targetInput.type = 'password';
                icon.classList.remove('ri-eye-line');
                icon.classList.add('ri-eye-off-line');
            }
        }
    }); 

})(jQuery);
</script>

@endsection