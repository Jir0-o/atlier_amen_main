<!-- navbar start -->
<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="{{ route('frontend.landing') }}">
            <img src="{{ asset('frontend-css/img/logo/logo-white.jpeg') }}" alt="Atlier Amen" loading="lazy">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ri-menu-2-line"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
            <div class="d-flex flex-column gap-1">
                <div class="d-flex gap-2 justify-content-between align-items-center d-md-block text-md-end">
                    <a href="#" class="fs-5 me-md-3" data-bs-toggle="modal" data-bs-target="#searchModal">
                        <i class="ri-search-line"></i>
                    </a>
                    @feature('shop_enabled')
                        @feature('cart_enabled')
                            <a href="{{ route('cart') }}" class="fs-5 me-md-3 position-relative">
                                <i class="ri-shopping-cart-2-line"></i>
                                @if (session('cart_count', 0) > 0)
                                    <span id="mini-cart-count"
                                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-warning text-light">
                                        {{ session('cart_count') }}
                                    </span>
                                @endif
                            </a>
                        @endfeature
                        @feature('wishlist_enabled')
                            <a href="{{ route('wishlist') }}" class="fs-5 me-md-3">
                                <i class="ri-heart-2-line"></i>
                            </a>
                        @endfeature
                    @endfeature
                    @guest
                        <a href="{{ route('frontend.login') }}" class="fs-5 me-md-3">
                            <i class="ri-user-line"></i>
                        </a>
                    @endguest
                    @auth
                        @if (auth()->user()->role == 1)
                            <a href="{{ route('dashboard') }}" class="fs-5 me-md-3">
                                <i class="ri-user-line"></i>
                            </a>
                        @else
                            <a href="{{ route('profile.show') }}" class="fs-5 me-md-3">
                                <i class="ri-user-line"></i>
                            </a>
                        @endif
                    @endauth
                    <a href="{{ route('contact') }}" class="fs-5">
                        <i class="ri-phone-line"></i>
                    </a>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link py-0 {{ request()->routeIs('index') ? 'active' : '' }}"
                            href="{{ route('index') }}">
                            Home
                            <span class="shape-nav">
                                <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png') }}"
                                    alt="Navbar shape">
                            </span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link py-0 dropdown-toggle text-white" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Works
                            <span class="shape-nav">
                                <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png') }}"
                                    alt="Navbar shape">
                            </span>
                        </a>
                        <ul class="dropdown-menu">
                            @forelse($navCategories as $cat)
                                <li>
                                    <a class="dropdown-item" href="{{ route('works.category', $cat) }}">
                                        {{ $cat->name }}
                                    </a>
                                </li>
                            @empty
                                <li><span class="dropdown-item text-muted">No categories yet</span></li>
                            @endforelse
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link py-0 {{ request()->routeIs('about') ? 'active' : '' }}"
                            href="{{ route('about') }}">
                            About
                            <span class="shape-nav">
                                <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png') }}"
                                    alt="Navbar shape">
                            </span>
                        </a>
                    </li>
                    @feature('shop_enabled')
                        <li class="nav-item">
                            <a class="nav-link py-0 {{ request()->routeIs('shop') ? 'active' : '' }}"
                                href="{{ route('shop') }}">
                                Shop
                                <span class="shape-nav">
                                    <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png') }}"
                                        alt="Navbar shape">
                                </span>
                            </a>
                        </li>
                    @endfeature
                    <li class="nav-item">
                        <a class="nav-link py-0 {{ request()->routeIs('exhibition') ? 'active' : '' }}"
                            href="{{ route('exhibition') }}">
                            VIP Exhibition
                            <span class="shape-nav">
                                <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png') }}"
                                    alt="Navbar shape">
                            </span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- navbar end -->

<!-- Search modal start -->
<div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content bg-transparent overflow-hidden">
            <div class="modal-header border-0 pb-1 cormorant bg-white">
                <h1 class="modal-title fs-5 fw-semibold" id="searchModalLabel">Search</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body bg-white">
                <input class="form-control" type="text" name="search" id="search"
                    placeholder="Search artworks, products, or collections...">
            </div>
            <div class="pt-3">
                <div class="pt-3" id="search-results-container">
                    <div class="modal-serach-result p-3 bg-white">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Search modal end -->

@push('scripts')
    <script>
        function userMenuLogout() {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Logout?',
                    text: 'You will be signed out of your account.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Logout',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        document.getElementById('user-menu-logout-form').submit();
                    }
                });
            } else {
                if (confirm('Logout?')) {
                    document.getElementById('user-menu-logout-form').submit();
                }
            }
        }

        $(document).ready(function() {
            let currentUrl = window.location.href;
            let pathname = window.location.pathname;

            $(".navbar-nav .nav-link").removeClass("active");

            $(".navbar-nav .nav-link").each(function() {
                let linkUrl = $(this).attr("href");
                if (linkUrl === "#" || $(this).attr("id") === "userMenuDropdown") return;

                try {
                    let linkPath = $("<a>").attr("href", linkUrl)[0].pathname;
                    if (pathname.startsWith(linkPath)) {
                        $(this).addClass("active");
                    }
                } catch (e) {
                    console.warn("Invalid link URL", linkUrl, e);
                }
            });

            if (pathname.includes("/works/")) {
                $(".nav-item.dropdown > .nav-link.dropdown-toggle").first().addClass("active");

                $(".dropdown-menu .dropdown-item").each(function() {
                    let subLink = $(this).attr("href");
                    try {
                        let subPath = $("<a>").attr("href", subLink)[0].pathname;
                        if (pathname === subPath) {
                            $(this).addClass("active");
                        }
                    } catch (e) {
                        console.warn("Invalid sub-link URL", subLink, e);
                    }
                });
            }


            let delayTimer;
            $('#search').on('keyup', function() {
                const query = $(this).val();

                clearTimeout(delayTimer);
                delayTimer = setTimeout(function() {
                    $.ajax({
                        url: "{{ route('search.live') }}",
                        method: "GET",
                        data: {
                            q: query
                        },
                        success: function(data) {
                            $('#search-results-container .modal-serach-result').html(
                                data);
                        },
                        error: function() {
                            $('#search-results-container .modal-serach-result').html(
                                '<p class="text-danger">Search failed. Try again.</p>'
                                );
                        }
                    });
                }, 300);
            });

            const isLoggedIn = @json(auth()->check());

            function syncGuestCart() {
                const cart = JSON.parse(localStorage.getItem('guest_cart') || '{}');
                if (Object.keys(cart).length === 0) {
                    return $.Deferred().resolve().promise();
                }
                return $.ajax({
                    url: "{{ route('cart.sync') }}",
                    method: 'POST',
                    contentType: 'application/json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: JSON.stringify({
                        items: cart
                    })
                }).always(() => {
                    localStorage.removeItem('guest_cart');
                    loadCart();
                });
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

            @if (auth()->check())
                syncGuestCart().always(resp => {
                    updateCartCount(resp?.cart_count || 0);
                });
            @endif
        });
    </script>
@endpush
