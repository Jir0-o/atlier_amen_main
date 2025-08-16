@extends('layouts.app')

@section('title', 'Shop Features')

@section('content')
<div class="content-wrapper">
    <div class="row">
        <div class="col-md-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex flex-wrap gap-3 justify-content-between align-items-center mb-3">
                        <h3 class="font-weight-bold m-0">Shop Features</h3>
                    </div>

                    {{-- Flash messages --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.shop.features.update') }}" id="shopFeaturesForm">
                        @csrf

                        @php
                            // Helper to resolve checkbox value from old() or DB fallback
                            $isOn = function ($key, $default = 1) use ($settings) {
                                // If form was submitted and failed validation, keep user's choice
                                if (!is_null(old($key))) return (bool) old($key);
                                // Otherwise use DB value or default
                                return (bool) ($settings[$key] ?? $default);
                            };
                        @endphp

                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" role="switch"
                                   id="shop_enabled" name="shop_enabled"
                                   {{ $isOn('shop_enabled') ? 'checked' : '' }}>
                            <label class="form-check-label" for="shop_enabled">
                                Enable Shop (global)
                            </label>
                            <div class="form-text">Turns the entire shop on/off. When off, all actions are disabled.</div>
                        </div>

                        <hr class="my-4">

                        <div class="row g-3">
                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input feature-toggle" type="checkbox" role="switch"
                                           id="cart_enabled" name="cart_enabled"
                                           {{ $isOn('cart_enabled') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="cart_enabled">
                                        Enable Add to Cart
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input feature-toggle" type="checkbox" role="switch"
                                           id="buy_now_enabled" name="buy_now_enabled"
                                           {{ $isOn('buy_now_enabled') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="buy_now_enabled">
                                        Enable Buy Now
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-check form-switch">
                                    <input class="form-check-input feature-toggle" type="checkbox" role="switch"
                                           id="wishlist_enabled" name="wishlist_enabled"
                                           {{ $isOn('wishlist_enabled') ? 'checked' : '' }}>
                                    <label class="form-check-label" for="wishlist_enabled">
                                        Enable Wishlist
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-4">
                            <button class="btn btn-primary" type="submit">Save</button>
                        </div>
                    </form>

                </div> {{-- card-body --}}
            </div> {{-- card --}}
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const shopSwitch = document.getElementById('shop_enabled');
    const featureToggles = document.querySelectorAll('.feature-toggle');

    function syncFeatureToggles() {
        const disabled = !shopSwitch.checked;
        featureToggles.forEach(el => {
            el.disabled = disabled;
            // Optional: visually dim labels
            const label = document.querySelector('label[for="' + el.id + '"]');
            if (label) label.style.opacity = disabled ? '0.6' : '1';
        });
    }

    shopSwitch.addEventListener('change', syncFeatureToggles);
    syncFeatureToggles(); // on load
})();
</script>
@endpush
