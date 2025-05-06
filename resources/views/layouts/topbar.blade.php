<!-- Topbar -->
<nav class="navbar navbar-expand navbar-light shadow-sm fixed-top" style="
    z-index: 1040;
    background: url('{{ asset('images/bgtopbar.png') }}');
    background-size: 200% auto;
    background-position: 20% center;
    background-repeat: no-repeat;
    height: 60px;
">
    <div class="container-fluid">
        <!-- Logo Toko -->
        <a class="navbar-brand me-3" href="#" style="padding-left: 40px;">
            <img src="{{ asset('images/iconTokoKu.png') }}" alt="Logo TokoKu" style="height: 70px;">
        </a>
        
        <!-- Tombol Toggle Sidebar -->
        <button class="btn btn-link d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#sidebarMobile">
            <i class="fas fa-bars"></i>
        </button>
        
        <!-- Menu User -->
        <div class="navbar-nav ms-auto">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown" style="text-shadow: 1px 1px 2px rgba(0,0,0,0.5);">
                    <i class="fas fa-user-circle me-1"></i>
                    {{ Auth::user()->name ?? 'Guest' }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profil</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>