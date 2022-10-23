<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('home') }}">
        <div class="sidebar-brand-icon">
            {{-- <img src="{{asset('img/logo2.png')}}" style="height: 40px;" alt="Image"> --}}
        </div>
        <div class="sidebar-brand-text mx-3">GO-UMA</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Nav::isRoute('home') }}">
        <a class="nav-link" href="{{ route('home') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>{{ __('Dashboard') }}</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Menu') }}
    </div>

    @if(Auth::user()->level == 0)
    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('category.index') }}">
        <a class="nav-link" href="{{ route('category.index') }}">
            <i class="fas fa-fw fa-tags"></i>
            <span>{{ __('Kategori') }}</span>
        </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('partner.index') }}">
        <a class="nav-link" href="{{ route('partner.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>{{ __('Mitra') }}</span>
        </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('product.index') }}">
        <a class="nav-link" href="{{ route('product.index') }}">
            <i class="fas fa-fw fa-cubes"></i>
            <span>{{ __('Produk') }}</span>
        </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('branch.index') }}">
        <a class="nav-link" href="{{ route('branch.index') }}">
            <i class="fas fa-fw fa-sitemap"></i>
            <span>{{ __('Cabang') }}</span>
        </a>
    </li>
    @else
    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('stock.index') }}">
        <a class="nav-link" href="{{ route('stock.index',array('id' => Auth::user()->id)) }}">
            <i class="fas fa-fw fa-cubes"></i>
            <span>{{ __('Stok Produk') }}</span>
        </a>
    </li>
    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('transaction.index') }}">
        <a class="nav-link" href="{{ route('transaction.index',array('id' => Auth::user()->id)) }}">
            <i class="fas fa-fw fa-shopping-cart"></i>
            <span>{{ __('Penjualan') }}</span>
        </a>
    </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        {{ __('Pengguna') }}
    </div>

    @if(Auth::user()->level == 0)
    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('user.index') }}">
        <a class="nav-link" href="{{ route('user.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Admin') }}</span>
        </a>
    </li>
    @endif

    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('kurir.index') }}">
        <a class="nav-link" href="{{ route('kurir.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Kurir') }}</span>
        </a>
    </li>

    <!-- Nav Item -->
    <li class="nav-item {{ Nav::isRoute('customer.index') }}">
        <a class="nav-link" href="{{ route('customer.index') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Pelanggan') }}</span>
        </a>
    </li>

    <!-- Nav Item - Profile -->
    <!-- <li class="nav-item {{ Nav::isRoute('profile') }}">
        <a class="nav-link" href="{{ route('profile') }}">
            <i class="fas fa-fw fa-user"></i>
            <span>{{ __('Profile') }}</span>
        </a>
    </li> -->

    <!-- Nav Item - About -->
    <!-- <li class="nav-item {{ Nav::isRoute('about') }}">
        <a class="nav-link" href="{{ route('about') }}">
            <i class="fas fa-fw fa-hands-helping"></i>
            <span>{{ __('About') }}</span>
        </a>
    </li> -->

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>