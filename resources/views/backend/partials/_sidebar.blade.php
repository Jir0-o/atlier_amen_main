<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        <li class="nav-item nav-profile border-bottom">
            <a href="#" class="nav-link flex-column">
                <div class="nav-profile-image">
                    <img src="{{ asset('plus-admin/images/faces/face1.jpg') }}" alt="profile" />
                    <!--change to offline or busy as needed-->
                </div>
                <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                    <span class="font-weight-semibold mb-1 mt-2 text-center">Atlier Amen</span>
                    {{-- <span class="text-secondary icon-sm text-center">$3499.00</span> --}}
                </div>
            </a>
        </li>
        <li class="nav-item pt-3">
            <a class="nav-link d-block" href="{{ route('dashboard') }}">
                <img class="sidebar-brand-logo" src="assets/images/logo.svg" alt="" />
                <img class="sidebar-brand-logomini" src="assets/images/logo-mini.svg" alt="" />
                <div class="small font-weight-light pt-1"></div>
            </a>
            <form class="d-flex align-items-center" action="#">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <i class="input-group-text border-0 mdi mdi-magnify"></i>
                    </div>
                    <input type="text" class="form-control border-0" placeholder="Search" />
                </div>
            </form>
        </li>
        <li class="pt-2 pb-1">
            <span class="nav-item-head">Quick Menu</span>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-compass-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#frontend_menu" aria-expanded="false"
                aria-controls="frontend_menu">
                <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                <span class="menu-title">Work/Product</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="frontend_menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                            <span class="menu-title">Work Category</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('works.index') }}">
                            <i class="mdi mdi-briefcase menu-icon"></i>
                            <span class="menu-title">My Work</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        {{-- list nav item for about contract --}}
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#contact_menu" aria-expanded="false"
                aria-controls="contact_menu">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Admin Info</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="contact_menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminAbout.index') }}">
                            <i class="mdi mdi-information menu-icon"></i>
                            <span class="menu-title">About</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminContract.index') }}">
                            <i class="mdi mdi-file-document-box menu-icon"></i>
                            <span class="menu-title">Contract</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#order_menu" aria-expanded="false"
                aria-controls="order_menu">
                <i class="mdi mdi-cart menu-icon"></i>
                <span class="menu-title">Order</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="order_menu">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">
                            <i class="mdi mdi-cart menu-icon"></i>
                            <span class="menu-title">Order</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact-messages.index') }}">
                            <i class="mdi mdi-message-text menu-icon"></i>
                            <span class="menu-title">Contact Messages</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#attribute_menu" aria-expanded="false"
                aria-controls="attribute_menu">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Attributes</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="attribute_menu">
                <ul class="nav flex-column sub-menu">                    
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.attributes.index') }}">
                            <i class="mdi mdi-tag menu-icon"></i>
                            <span class="menu-title">Attribute</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.attribute-values.index') }}">
                            <i class="mdi mdi-tag-multiple menu-icon"></i>
                            <span class="menu-title">Attribute Value</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Settings <i class="menu-arrow"></i></span>
            </a>
            <div class="collapse" id="ui-basic">
                <ul class="nav flex-column sub-menu">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.index') }}">
                            <i class="mdi mdi-account menu-icon"></i>
                            <span class="menu-title">Users</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.shop.features.edit') }}">
                            <i class="mdi mdi-cart menu-icon"></i>
                            <span class="menu-title">Shop Settings</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.footer.settings.index') }}">
                            <i class="mdi mdi-footprint menu-icon"></i>
                            <span class="menu-title">Footer Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        <li class="nav-item">
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            <a class="nav-link text-danger" href="#" onclick="event.preventDefault(); confirmLogout();">
                <i class="mdi mdi-logout menu-icon"></i>
                <span class="menu-title">Logout</span>
            </a>
        </li>
    </ul>
</nav>
@push('scripts')
    <script>
        function confirmLogout() {
            Swal.fire({
                title: 'Logout?',
                text: "You will be signed out of your account.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Yes, Logout',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
@endpush
