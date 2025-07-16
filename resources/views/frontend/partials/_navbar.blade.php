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
                        <li>
                            <a class="dropdown-item" href="./drawing.html">Drawings</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./midea.html">Mixed media</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./painting.html">Paintings</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./ceramic.html">Ceramics</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./illustration&book.html">Illustrations and books</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="./random.html">Random objects</a>
                        </li>
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
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('frontend.login') }}">
                        Login
                        <span class="shape-nav">
                            <img class="w-100" src="{{ asset('frontend-css/img/shape/shape-nav.png')}}" alt="Navbar shape">
                        </span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>