<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Point of Sales') - Spark Admin</title>

    <!-- SEO Optimization -->
    <meta name="description" content="Point of Sales - Spark Admin Premium Bootstrap 5 Admin Dashboard Template">
    <meta name="author" content="Spark Admin Team">

    @include('inc.css')
</head>

<body>

    <!-- ==========================================
        START: Sidebar Component
        ========================================== -->
    <div class="sidebar-wrapper" id="sidebar">
        <!-- Brand Logo / Identity -->
        <a href="{{ route('dashboard.index') }}" class="sidebar-brand">
            <i class="bi bi-asterisk"></i>
            <span>Umar - Point of Sales</span>
        </a>

        <!-- Navigation Menu -->
        <div class="flex-grow-1 overflow-y-auto">
            <!-- Group: Menu -->
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Menu</div>
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('dashboard.index') }}" class="sidebar-menu-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}" id="menu-dashboard" title="Dashboard">
                            <i class="bi bi-grid-fill"></i>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('user.index') }}" class="sidebar-menu-link {{ request()->routeIs('user.*') ? 'active' : '' }}" id="menu-user" title="User">
                            <i class="bi bi-people-fill"></i>
                            <span>User</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('category.index') }}" class="sidebar-menu-link {{ request()->routeIs('category.*') ? 'active' : '' }}" id="menu-category" title="Category">
                            <i class="bi bi-tags-fill"></i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('role.index') }}" class="sidebar-menu-link {{ request()->routeIs('role.*') ? 'active' : '' }}" id="menu-role" title="Role">
                            <i class="bi bi-shield-fill-check"></i>
                            <span>Role</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('product.index') }}" class="sidebar-menu-link {{ request()->routeIs('product.*') ? 'active' : '' }}" id="menu-product" title="Product">
                            <i class="bi bi-box-seam-fill"></i>
                            <span>Product</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('order.index') }}" class="sidebar-menu-link {{ request()->routeIs('order.*') ? 'active' : '' }}" id="menu-order" title="Order">
                            <i class="bi bi-cart-fill"></i>
                            <span>Transaction</span>
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Group: Laporan (Admin & Pimpinan) -->
            @if(Auth::user() && (Auth::user()->isAdmin() || Auth::user()->isLeader()))
            <div class="sidebar-menu-section">
                <div class="sidebar-menu-title">Laporan</div>
                <ul class="sidebar-menu-list">
                    <li class="sidebar-menu-item">
                        <a href="{{ route('report.daily') }}" class="sidebar-menu-link {{ request()->routeIs('report.daily') ? 'active' : '' }}">
                            <i class="bi bi-calendar-day"></i>
                            <span>Laporan Harian</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('report.weekly') }}" class="sidebar-menu-link {{ request()->routeIs('report.weekly') ? 'active' : '' }}">
                            <i class="bi bi-calendar-week"></i>
                            <span>Laporan Mingguan</span>
                        </a>
                    </li>
                    <li class="sidebar-menu-item">
                        <a href="{{ route('report.monthly') }}" class="sidebar-menu-link {{ request()->routeIs('report.monthly') ? 'active' : '' }}">
                            <i class="bi bi-calendar-month"></i>
                            <span>Laporan Bulanan</span>
                        </a>
                    </li>
                </ul>
            </div>
            @endif
        </div>

        <!-- Sidebar Profile Card (Dynamic Footer) -->
        <div class="sidebar-profile">
            <img src="{{ asset('assets/images/avatar.png') }}" alt="Administrator" class="sidebar-profile-img"
                onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
            <div class="sidebar-profile-info">
                <div class="sidebar-profile-name">{{ Auth::user()->name ?? 'Administrator' }}</div>
                <div class="sidebar-profile-email">{{ Auth::user()->email ?? 'admin@email.com' }}</div>
            </div>
        </div>
    </div>
    <!-- ==========================================
        END: Sidebar Component
        ========================================== -->


    <!-- ==========================================
        START: Main Content Area
        ========================================== -->
    <div class="main-wrapper">

        <!-- START: Top Navbar Component -->
        <header class="navbar-custom">
            <div class="navbar-left">
                <!-- Desktop sidebar toggle (visible on large screens only) -->
                <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
                    id="desktop-sidebar-toggle"
                    data-bs-toggle="tooltip"
                    data-bs-placement="bottom"
                    title="Minimize Sidebar">
                    <i class="bi bi-layout-sidebar-inset"></i>
                </button>
                <!-- Mobile sidebar toggle -->
                <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
                    <i class="bi bi-list"></i>
                </button>

                <!-- Quick Actions Dropdown -->
                <div class="dropdown ms-2">
                    <button class="btn-quick-action dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                        id="quick-actions-dropdown">
                        <i class="bi bi-plus-lg"></i>
                        <span>Create</span>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-quick-action" aria-labelledby="quick-actions-dropdown">
                        <li class="dropdown-header">Quick Action Shortcuts</li>
                        <li><a class="dropdown-item" href="{{ route('category.create') }}"><i class="bi bi-tag-plus"></i> New Category</a></li>
                        <li><a class="dropdown-item" href="{{ route('product.create') }}"><i class="bi bi-box-seam"></i> New Product</a></li>
                        <li><a class="dropdown-item" href="{{ route('user.create') }}"><i class="bi bi-person-plus"></i> New User</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> System Settings</a></li>
                    </ul>
                </div>
            </div>

            <!-- Mid navbar: search pill -->
            <div class="navbar-search-wrapper">
                <input type="text" class="navbar-search-input" placeholder="Search anything in Spark..." id="main-search">
                <button class="navbar-search-btn" aria-label="Search">
                    <i class="bi bi-search"></i>
                </button>
            </div>

            <!-- Right actions -->
            <div class="navbar-actions">
                <!-- Fullscreen Toggle -->
                <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
                    <i class="bi bi-arrows-fullscreen"></i>
                </button>

                <!-- Notifications -->
                <div class="dropdown">
                    <button class="navbar-action-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" id="btn-notifications" data-bs-auto-close="outside">
                        <i class="bi bi-bell"></i>
                        <span class="navbar-action-badge"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-notification p-0"
                        aria-labelledby="btn-notifications">
                        <div class="notification-header">
                            <h6 class="notification-title">Notifications</h6>
                            <button class="btn-clear-all" type="button">Mark all read</button>
                        </div>
                        <div class="notification-list">
                            <a href="#" class="notification-item">
                                <div class="notification-icon bg-success text-white">
                                    <i class="bi bi-wallet2"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="notification-text">New sale received: <strong>$150.00</strong></p>
                                    <span class="notification-time">2 mins ago</span>
                                </div>
                                <span class="notification-unread-dot"></span>
                            </a>
                            <a href="#" class="notification-item">
                                <div class="notification-icon bg-primary text-white">
                                    <i class="bi bi-person-plus-fill"></i>
                                </div>
                                <div class="notification-content">
                                    <p class="notification-text">New user registered: <strong>John Doe</strong></p>
                                    <span class="notification-time">1 hour ago</span>
                                </div>
                                <span class="notification-unread-dot"></span>
                            </a>
                        </div>
                        <a href="#" class="notification-footer">View All Notifications</a>
                    </div>
                </div>

                <!-- Profile Dropdown -->
                <div class="dropdown ms-2">
                    <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
                        aria-expanded="false" id="profile-dropdown">
                        <img src="{{ asset('assets/images/avatar.png') }}" alt="Profile Image" class="navbar-profile-img"
                            onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
                        <span class="navbar-profile-name d-none d-md-inline">{{ Auth::user()->name ?? 'Administrator' }}</span>
                        <i class="bi bi-chevron-down navbar-profile-caret"></i>
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
                        <li class="dropdown-header">Welcome, {{ Auth::user()->name ?? 'User' }}!</li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-person"></i> My Account</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-gear"></i> Settings</a></li>
                        <li><a class="dropdown-item" href="#"><i class="bi bi-lock"></i> Lock Screen</a></li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <!-- END: Top Navbar Component -->

        <!-- START: Content Area -->
        @yield('content')
        <!-- END: Content Area -->

        <!-- START: Footer -->
        <footer class="footer-custom">
            <div class="footer-left">
                <span class="footer-logo">
                    <i class="bi bi-asterisk"></i> Spark Admin
                </span>
                <span class="footer-separator">|</span>
                <span class="footer-copy">&copy; 2026 Made with <i class="bi bi-heart-fill text-danger footer-heart"></i> by
                    <a href="https://sparkadminpro.gumroad.com/" target="_blank">Spark Admin</a> • Distributed by
                    <a href="https://www.themewagon.com/" target="_blank">ThemeWagon</a>
                </span>
            </div>
            <div class="footer-right">
                <ul class="footer-links">
                    <li><a href="#" class="footer-link">Overview</a></li>
                    <li><a href="#" class="footer-link">Statistics</a></li>
                    <li><a href="#" class="footer-link">Help & Documentation</a></li>
                    <li><a href="#" class="footer-link">Status <span class="status-dot"></span></a></li>
                </ul>
            </div>
        </footer>
        <!-- END: Footer -->

    </div>
    <!-- ==========================================
        END: Main Content Area
        ========================================== -->

    <!-- ==========================================
        START: Scripts
        ========================================== -->
    <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/dashboard.js') }}"></script>
    <!-- ==========================================
        END: Scripts
        ========================================== -->
</body>

</html>
