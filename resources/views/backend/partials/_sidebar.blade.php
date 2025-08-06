<nav class="sidebar sidebar-offcanvas" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile border-bottom">
      <a href="#" class="nav-link flex-column">
        <div class="nav-profile-image">
          <img src="{{ asset('plus-admin/images/faces/face1.jpg') }}" alt="profile" />
          <!--change to offline or busy as needed-->
        </div>
        <div class="nav-profile-text d-flex ml-0 mb-3 flex-column">
          <span class="font-weight-semibold mb-1 mt-2 text-center">Antonio Olson</span>
          <span class="text-secondary icon-sm text-center">$3499.00</span>
        </div>
      </a>
    </li>
    <li class="nav-item pt-3">
      <a class="nav-link d-block" href="index.html">
        <img class="sidebar-brand-logo" src="assets/images/logo.svg" alt="" />
        <img class="sidebar-brand-logomini" src="assets/images/logo-mini.svg" alt="" />
        <div class="small font-weight-light pt-1">Responsive Dashboard</div>
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
      <span class="nav-item-head">Template Pages</span>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="{{ route('dashboard') }}">
        <i class="mdi mdi-compass-outline menu-icon"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        <span class="menu-title">Frontend</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('categories.index') }}">Work Category</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('adminAbout.index')}}">About</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('adminContract.index')}}">Contract</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('contact-messages.index')}}">Contract Message</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-toggle="collapse" href="#ui-basic" aria-expanded="false" aria-controls="ui-basic">
        <i class="mdi mdi-crosshairs-gps menu-icon"></i>
        <span class="menu-title">Backend</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse" id="ui-basic">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <a class="nav-link" href="{{ route('works.index') }}">My Work</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.orders.index')}}">Order</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.attributes.index')}}">Attribute</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('admin.attribute-values.index')}}">Attribute Value</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="{{route('contact-messages.index')}}">Contract Message</a>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/icons/mdi.html">
        <i class="mdi mdi-contacts menu-icon"></i>
        <span class="menu-title">Icons</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/forms/basic_elements.html">
        <i class="mdi mdi-format-list-bulleted menu-icon"></i>
        <span class="menu-title">Forms</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/charts/chartjs.html">
        <i class="mdi mdi-chart-bar menu-icon"></i>
        <span class="menu-title">Charts</span>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="pages/tables/basic-table.html">
        <i class="mdi mdi-table-large menu-icon"></i>
        <span class="menu-title">Tables</span>
      </a>
    </li>
    <li class="nav-item pt-3">
      <a class="nav-link" href="http://bootstrapdash.com/demo/plus-free/documentation/documentation.html" target="_blank">
        <i class="mdi mdi-file-document-box menu-icon"></i>
        <span class="menu-title">Documentation</span>
      </a>
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