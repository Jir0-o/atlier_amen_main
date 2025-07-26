@extends('layouts.guest')

@section('title', $work->name ?? 'Art Information')

@php
    $pageUrl   = url()->current(); 
    $shareText = $work->name ? $work->name.' by '.$category->name : 'Check this artwork';

    $facebookShare = 'https://www.facebook.com/sharer/sharer.php?u='.urlencode($pageUrl);
    $twitterShare  = 'https://twitter.com/intent/tweet?'.http_build_query([
        'url'  => $pageUrl,
        'text' => $shareText,
    ]);
@endphp

@section('content')
<!-- main content start -->
<main>
    <div class="content">
        <!-- portrait information start -->
        <section class="section-gap px-4">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="indi-img-box" data-aos="flip-left" data-aos-duration="2000">
                        <video src={{ $work->art_video}} controls autoplay></video>
                    </div>
                </div>
                {{-- Main Image + Gallery --}}
                <div class="col-sm-4 mb-4">
                    <div class="indi-img-box recent-img-box" data-aos="flip-left" data-aos-duration="2000">
                        {{-- Main Image --}}
                        <img 
                            src="{{ $work->work_image_url ?? $work->work_image_low_url ?? '' }}" 
                            alt="{{ $work->name }}" 
                            id="indi-img-preview" 
                            loading="lazy"
                            class="img-fluid w-100">

                        {{-- Hover Images --}}
                        @if(!empty($work->image_left))
                            <img class="recent-img-hover img-left" 
                                src="{{ asset($work->image_left) }}" 
                                alt="{{ $work->name }} Left Hover" 
                                loading="lazy">
                        @endif
                        @if(!empty($work->image_right))
                            <img class="recent-img-hover img-right" 
                                src="{{ asset($work->image_right) }}" 
                                alt="{{ $work->name }} Right Hover" 
                                loading="lazy">
                        @endif
                    </div>

                    {{-- Gallery Thumbs --}}
                    @if($work->gallery->isNotEmpty())
                        <div class="indi-img-gallery my-4">
                            <div class="row">
                                @foreach($work->gallery as $gIndex => $g)
                                    @php
                                        $thumbSrc = $g->image_low_url ?? $g->image_url;
                                        $fullSrc  = $g->image_url; // Full-size image
                                        $isActive = $gIndex === 0 ? 'active' : '';
                                    @endphp
                                    <div class="col-3 p-3">
                                        <div class="{{ $isActive }}">
                                            <img src="{{ $thumbSrc }}"
                                                data-full="{{ $fullSrc }}"
                                                alt="portrait preview"
                                                class="indi-thumb-img img-thumb"
                                                loading="lazy">
                                            {{-- If thumbs have hover states --}}
                                            @if(!empty($g->image_left))
                                                <img class="recent-img-hover img-left" 
                                                    src="{{ asset($g->image_left) }}" 
                                                    alt="Thumb Hover Left" 
                                                    loading="lazy">
                                            @endif
                                            @if(!empty($g->image_right))
                                                <img class="recent-img-hover img-right" 
                                                    src="{{ asset($g->image_right) }}" 
                                                    alt="Thumb Hover Right" 
                                                    loading="lazy">
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                {{-- Info --}}
                <div class="col-sm-4 mb-4">
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
                                        <td>: {{ $work->name }}</td>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <td>:
                                            @if($work->work_date)
                                                {{ $work->work_date->format('M d, Y') }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tag</th>
                                        <td>:
                                            @if($work->tags)
                                                {{ $work->tags }}
                                            @else
                                                —
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Category</th>
                                        <td>: {{ $category->name ?? '—' }}</td>
                                    </tr>
                                </tbody>
                            </table>

                            {{-- Details --}}
                            <h4 class="text-decoration-underline playfair fw-bold mb-3 mt-4">Details:</h4>
                            <div class="poppins">
                                {!! $work->details ?: '<p>No details added.</p>' !!}
                            </div>
                            <br>
                            <h4 class="playfair fw-bold mb-3">Price: $ {{ $work->price }}</h4>

                            {{-- Share --}}
                            <h4 class="text-decoration-underline playfair fw-bold mb-3 mt-4">Share:</h4>
                            <div class="d-flex gap-3 flex-wrap jacques mb-4">
                                <a href="{{ $facebookShare }}" target="_blank" rel="noopener" class="btn btn-outline-light rounded-5">
                                    <i class="ri-facebook-line"></i>
                                    Facebook
                                </a>
                                <a href="{{ $twitterShare }}" target="_blank" rel="noopener" class="btn btn-outline-light rounded-5">
                                    <i class="ri-twitter-line"></i>
                                    Twitter
                                </a>
                                <button type="button" class="btn btn-outline-light rounded-5 js-copy-link" data-copy="{{ $pageUrl }}">
                                    <i class="ri-instagram-line"></i>
                                    Instagram
                                </button>
                            </div>
                            {{-- Cart / Buy --}}
                                <div class="row">
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex flex-column">
                                            <button 
                                                type="button"
                                                class="btn btn-outline-light btn-add-to-cart"
                                                data-work-id="{{ $work->id }}">
                                                Add to Cart
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-4 mb-2">
                                        <div class="d-flex flex-column">
                                            <button type="button" class="btn btn-warning text-white btn-buy-now" data-work-id="{{ $work->id }}">
                                                Buy Now
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div><!-- /.row buttons -->
                        </div><!-- /.art-info -->
                    </div><!-- /.aos wrapper -->
                </div><!-- /.col info -->
            </div><!-- /.row -->
        </section>
        <!-- portrait information end -->
    </div>
</main>
<!-- main content end -->
@endsection

@push('scripts')
<script>
$(function() {
    const isLoggedIn = @json(auth()->check());
    // 1. Image preview switch
    $('.indi-thumb-img').on('click', function() {
        const fullSrc = $(this).data('full') || $(this).attr('src');
        $('#indi-img-preview').attr('src', fullSrc);
        $('.indi-img-gallery .active').removeClass('active');
        $(this).parent().addClass('active');
    });

    // 2. Copy URL to clipboard
    $('.js-copy-link').on('click', function() {
        const url = $(this).data('copy');
        navigator.clipboard?.writeText(url)
            .then(() => showCopiedToast('Link copied! Paste in Instagram.'))
            .catch(() => prompt('Copy this link:', url));
    });

    function showCopiedToast(msg) {
        if (window.Swal) {
            Swal.fire({ icon:'success', title: msg, timer:1200, showConfirmButton:false });
        } else {
            alert(msg);
        }
    }

    function guestCartCount() {
        const cart = JSON.parse(localStorage.getItem('guest_cart') || '{}');
        return Object.values(cart).reduce((sum, qty) => sum + qty, 0);
    }

    // 3. Update mini‑cart badge
    function updateCartCount(count) {
        $('#mini-cart-count').text(count);
    }

    if (!isLoggedIn) {
        updateCartCount(guestCartCount());
    }

    // 4. Save to localStorage for guest
    function saveCartToLocal(workId, qty) {
        const cart = JSON.parse(localStorage.getItem('guest_cart') || '{}');
        cart[workId] = (cart[workId] || 0) + qty;
        localStorage.setItem('guest_cart', JSON.stringify(cart));
    }

    // 5. Sync guest cart after login/register
    function syncGuestCart() {
        const cart = JSON.parse(localStorage.getItem('guest_cart') || '{}');
        if (!Object.keys(cart).length) return;

        $.ajax({
            url: "{{ route('cart.sync') }}",
            method: 'POST',
            contentType: 'application/json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: JSON.stringify({ items: cart })
        }).always(() => {
            localStorage.removeItem('guest_cart');
        });
    }

    // 6. Add to Cart
    $('.btn-add-to-cart').on('click', function(e) {
        e.preventDefault();
        const $btn   = $(this);
        const workId = $btn.data('work-id');
        if (!workId) return;

        // === For guests: only localStorage, no DB call ===
        if (!isLoggedIn) {
        saveCartToLocal(workId, 1);
        updateCartCount(guestCartCount()); 
        showCopiedToast('Added to cart');
        return;
        }

        // === For logged‑in users: persist immediately to your DB ===
        $btn.prop('disabled', true).text('Adding...');
        $.ajax({
        url: "{{ route('cart.add') }}",
        method: 'POST',
        contentType: 'application/json',
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        data: JSON.stringify({ work_id: workId })
        })
        .done(resp => {
        if (resp.status === 'success') {
            updateCartCount(resp.cart_count);
            showCopiedToast(resp.message); // e.g. “Added to cart”
        } else {
            throw new Error(resp.message);
        }
        })
        .fail(xhr => {
        showCopiedToast(xhr.responseJSON?.message || 'Failed to add');
        })
        .always(() => {
        $btn.prop('disabled', false).text('Add to Cart');
        });
    });

    // 7. Buy Now
    $('.btn-buy-now').on('click', function(e) {
        e.preventDefault();
        const workId = $(this).data('work-id');
        if (!workId) return;

        $.ajax({
            url: "{{ route('cart.add') }}",
            method: 'POST',
            contentType: 'application/json',
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            data: JSON.stringify({ work_id: workId })
        })
        .done(resp => {
            if (resp.status === 'success') {
            window.location.href = "{{ route('checkout.form') }}" + '?buy_now_id=' + workId;
            } else {
            throw new Error(resp.message);
            }
        })
        .fail(xhr => {
            showCopiedToast(xhr.responseJSON?.message || 'Purchase failed');
        });
    });
});
</script>
@endpush
