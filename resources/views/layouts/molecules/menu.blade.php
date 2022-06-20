<aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
    <div class="container-xxl d-flex h-100">
        <ul class="menu-inner">
            <li class="menu-item {{ ($ROUTE === 'dashboard.index') ? 'active' : '' }}">
                <a href="{{ route('dashboard.index') }}" class="menu-link">
                    <i class="menu-icon tf-icons bx bx-home-circle"></i>
                    <div>Dashboard</div>
                </a>
            </li>
        </ul>
    </div>
</aside>
