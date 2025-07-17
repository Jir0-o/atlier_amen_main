<nav class="navbar navbar-expand-lg">
    <div class="container-fluid">
        <a class="navbar-brand" href="/"> 
            <img src="{{ asset('frontend-css/img/logo/logo-white.jpeg')}}" alt="Atlier Amen" loading="lazy">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="ri-menu-2-line"></span>
        </button>
        <div class="collapse navbar-collapse flex-grow-0" id="navbarNav">
            <ul class="navbar-nav"> 
                <li class="nav-item">
                    <a class="nav-link active" href="{{ route('index') }}">
                        Home
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                        </span>
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                        Works
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
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
                    <a class="nav-link" href="{{ route('about') }}">
                        About
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('contact') }}">
                        Say Hi
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('shop') }}">
                        Shop
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('exhibition') }}">
                        VIP Exhibition
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                        </span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('cart') }}">
                        Cart
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                        </span>
                    </a>
                </li>
                @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('frontend.login') }}">
                            Login
                            <span class="shape-nav">
                                <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                            </span>
                        </a>
                    </li>
                @endguest

                {{-- Authenticated: show user dropdown --}}
                @auth
                    @php
                        $authUser = Auth::user();
                        $displayName = $authUser->first_name
                            ?? $authUser->name
                            ?? 'Account';
                    @endphp

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userMenuDropdown"
                        role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ $displayName }}
                            <span class="shape-nav">
                                <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                            </span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="userMenuDropdown">
                            {{-- Adjust route names as needed --}}
                            <li>
                                <a class="dropdown-item" href="{{ route('profile.show') }}">
                                    <i class="mdi mdi-account-circle me-1"></i> Profile
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('dashboard') }}">
                                    <i class="mdi mdi-view-dashboard me-1"></i> Dashboard
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="#"
                                onclick="event.preventDefault(); userMenuLogout();">
                                    <i class="mdi mdi-logout me-1"></i> Logout
                                </a>
                            </li>
                        </ul>
                    </li>
                    <form id="user-menu-logout-form" action="{{ route('logout') }}" method="POST" style="display:none;">
                        @csrf
                    </form>
                @endauth
            </ul>
        </div>
    </div>
</nav>
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
        // Fallback: simple confirm()
        if (confirm('Logout?')) {
            document.getElementById('user-menu-logout-form').submit();
        }
    }
}
</script>
@endpush
