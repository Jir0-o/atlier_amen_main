<nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
        @php
            use Illuminate\Support\Facades\Crypt;
            use Illuminate\Support\Facades\Storage;
            use Illuminate\Support\Str;

            $u = auth()->user();
            $enc = Crypt::encryptString($u->id);

            $photo = $u->photo_path ? asset($u->photo_path)
                                        : asset('plus-admin/images/faces/face1.jpg');
        @endphp

        <li class="nav-item nav-profile border-bottom">
            <a href="{{ route('admin.profile.edit', $enc) }}" class="nav-link flex-column" title="Profile settings">
                <div class="nav-profile-image">
                    <img src="{{ $photo }}" alt="profile" />
                </div>
                <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
                    <span class="font-weight-semibold mb-1 mt-2 text-center">{{ $u?->name ?? 'Profile' }}</span>
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
        @can('Can View Dashboard')
        <li class="nav-item">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="mdi mdi-compass-outline menu-icon"></i>
                <span class="menu-title">Dashboard</span>
            </a>
        </li>
        @endcan
        @can('Can View Work/Product')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#frontend_menu" aria-expanded="false"
                aria-controls="frontend_menu">
                <i class="mdi mdi-view-dashboard-outline menu-icon"></i>
                <span class="menu-title">Work/Product</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="frontend_menu">
                <ul class="nav flex-column sub-menu">
                    @can('Can Access Work Category')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('categories.index') }}">
                            <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                            <span class="menu-title">Work Category</span>
                        </a>
                    </li>
                    @endcan
                    @can('Can Access My Work')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('works.index') }}">
                            <i class="mdi mdi-briefcase menu-icon"></i>
                            <span class="menu-title">My Work</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
        {{-- list nav item for about contract --}}
        @can('Can View Admin Info')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#contact_menu" aria-expanded="false"
                aria-controls="contact_menu">
                <i class="mdi mdi-account-multiple menu-icon"></i>
                <span class="menu-title">Admin Info</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="contact_menu">
                <ul class="nav flex-column sub-menu">
                    @can('Can Access About')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminAbout.index') }}">
                            <i class="mdi mdi-information menu-icon"></i>
                            <span class="menu-title">About</span>
                        </a>
                    </li>
                    @endcan
                    @can('Can Access Contact')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('adminContract.index') }}">
                            <i class="mdi mdi-file-document-box menu-icon"></i>
                            <span class="menu-title">Contact</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
        @can('Can View Order')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#order_menu" aria-expanded="false"
                aria-controls="order_menu">
                <i class="mdi mdi-cart menu-icon"></i>
                <span class="menu-title">Order</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="order_menu">
                <ul class="nav flex-column sub-menu">
                    @can('Can Access Order')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.orders.index') }}">
                            <i class="mdi mdi-cart menu-icon"></i>
                            <span class="menu-title">Order</span>
                        </a>
                    </li>
                    @endcan
                    @can('Can Access Contact Messages')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact-messages.index') }}">
                            <i class="mdi mdi-message-text menu-icon"></i>
                            <span class="menu-title">Contact Messages</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
        @can('Can View Attribute')
        <li class="nav-item">
            <a class="nav-link" data-toggle="collapse" href="#attribute_menu" aria-expanded="false"
                aria-controls="attribute_menu">
                <i class="mdi mdi-format-list-bulleted menu-icon"></i>
                <span class="menu-title">Attributes</span>
                <i class="menu-arrow"></i>
            </a>
            <div class="collapse" id="attribute_menu">
                <ul class="nav flex-column sub-menu">  
                    @can('Can Access Attribute')                  
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.attributes.index') }}">
                            <i class="mdi mdi-tag menu-icon"></i>
                            <span class="menu-title">Attribute</span>
                        </a>
                    </li>
                    @endcan
                    @can('Can Access Attribute Value')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('admin.attribute-values.index') }}">
                            <i class="mdi mdi-tag-multiple menu-icon"></i>
                            <span class="menu-title">Attribute Value</span>
                        </a>
                    </li>
                    @endcan
                </ul>
            </div>
        </li>
        @endcan
        @can('Can Access Settings')
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
                    <li class="nav-item"></li>
                        <a class="nav-link" href="{{ route('backend.settings') }}">
                            <i class="mdi mdi-image menu-icon"></i>
                            <span class="menu-title">Permission Settings</span>
                        </a>
                    </li>
                </ul>
            </div>
        </li>
        @endcan
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
