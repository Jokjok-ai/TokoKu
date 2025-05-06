<!-- resources/views/layouts/sidebar.blade.php -->

<nav class="d-flex flex-column bg-primary text-white position-fixed start-0 top-0 h-100" style="width: 250px; z-index: 1030; margin-top: 60px;">
    <div class="p-3">
        <a class="d-flex align-items-center text-white text-decoration-none mb-4">
            <i class="fas fa-store fs-4 me-2"></i>
            <span class="fs-4">Inventaris Toko</span>
        </a>
        
        <ul class="nav nav-pills flex-column">
            <!-- Dashboard -->
            <li class="nav-item">
                <a class="nav-link text-dark {{ request()->routeIs('dashboard') ? 'active bg-light' : '' }}" 
                   href="{{ route('dashboard') }}">
                    <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                </a>
            </li>
            
            <!-- Inventory -->
            <li>
                <a class="nav-link text-dark {{ request()->routeIs('items.*') ? 'active bg-light' : '' }}" 
                   href="{{ route('items.index') }}">
                    <i class="fas fa-boxes me-2"></i>
                    Data Barang
                </a>
            </li>
            <li>
                <a class="nav-link text-dark {{ request()->routeIs('stockin.*') ? 'active bg-light' : '' }}" 
                   href="{{ route('stockin.index') }}">
                    <i class="fas fa-arrow-circle-down me-2"></i>
                    Barang Masuk
                </a>
            </li>
            <li>
                <a class="nav-link text-dark {{ request()->routeIs('stockout.*') ? 'active bg-light' : '' }}" 
                   href="{{ route('stockout.index') }}">
                    <i class="fas fa-arrow-circle-up me-2"></i>
                    Barang Keluar
                </a>
            </li>
            
            <!-- Reports (Super Admin Only) -->
            @can('access-reports')
            <li class="nav-item dropdown">
                <a class="nav-link text-dark dropdown-toggle {{ request()->routeIs('reports.*') ? 'active bg-light' : '' }}" 
                   href="#" id="reportsDropdown" role="button" data-bs-toggle="dropdown">
                    <i class="fas fa-file-alt me-2"></i>
                    Laporan
                </a>
                <ul class="dropdown-menu bg-primary w-100">
                    <li>
                        <a class="dropdown-item text-dark {{ request()->routeIs('reports.index') ? 'active bg-light' : '' }}" 
                           href="{{ route('reports.index') }}">
                            Overview
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-dark {{ request()->routeIs('reports.stock') ? 'active bg-light' : '' }}" 
                           href="{{ route('reports.stock') }}">
                            Stok
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-dark {{ request()->routeIs('reports.transaction') ? 'active bg-light' : '' }}" 
                           href="{{ route('reports.transaction') }}">
                            Transaksi
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-dark {{ request()->routeIs('reports.profit') ? 'active bg-light' : '' }}" 
                           href="{{ route('reports.profit') }}">
                            Profit
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item text-dark {{ request()->routeIs('reports.category') ? 'active bg-light' : '' }}" 
                           href="{{ route('reports.category') }}">
                            Kategori
                        </a>
                    </li>
                </ul>
            </li>
            @endcan
            
            <!-- User Management (Super Admin Only) -->
            @can('manage-users')
            <li>
                <a class="nav-link text-dark {{ request()->routeIs('users.*') ? 'active bg-light' : '' }}" 
                   href="{{ route('users.index') }}">
                    <i class="fas fa-users me-2"></i>
                    Manajemen User
                </a>
            </li>
            @endcan
        </ul>
        
        <!-- Current User Info -->
        <div class="mt-auto pt-3 border-top">
            <div class="d-flex align-items-center">
                <div class="flex-shrink-0">
                    <i class="fas fa-user-circle fs-3"></i>
                </div>
                <div class="flex-grow-1 ms-3">
                    <div class="fw-bold">{{ auth()->user()->name }}</div>
                    <small class="text-white-50 text-capitalize">{{ auth()->user()->role }}</small>
                </div>
            </div>
        </div>
    </div>
</nav>