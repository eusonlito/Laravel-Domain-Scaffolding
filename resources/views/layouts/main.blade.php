<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="body-{{ str_replace('.', '-', $ROUTE) }}">
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
            <div class="layout-container">
                <nav class="layout-navbar navbar navbar-expand-xl align-items-center bg-navbar-theme" id="layout-navbar">
                    <div class="container-xxl">
                        <div class="navbar-brand app-brand demo d-none d-xl-flex py-0 me-4">
                            <a href="{{ route('dashboard.index') }}" class="app-brand-link gap-2">
                                <span class="app-brand-text demo menu-text fw-bold">PROJECT</span>
                            </a>
                        </div>

                        <aside id="layout-menu" class="layout-menu-horizontal menu-horizontal menu bg-menu-theme flex-grow-0">
                            <div class="container-xxl d-flex h-100">
                                <ul class="menu-inner">
                                    <!-- Dashboards -->
                                    <li class="menu-item active">
                                        <a href="javascript:void(0)" class="menu-link">
                                            <i class="menu-icon tf-icons bx bx-home-circle"></i>
                                            <div>Dashboard</div>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </aside>

                        <div class="navbar-nav-right d-flex align-items-center" id="navbar-collapse">
                            <ul class="navbar-nav flex-row align-items-center ms-auto">
                                <li class="nav-item navbar-dropdown dropdown-user dropdown">
                                    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
                                        <div class="avatar">
                                            <img src="../../assets/img/avatars/1.png" alt class="rounded-circle" />
                                        </div>
                                    </a>

                                    <ul class="dropdown-menu dropdown-menu-end">
                                        <li>
                                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                                <div class="d-flex">
                                                    <div class="flex-shrink-0 me-3">
                                                        <div class="avatar avatar-online">
                                                            <img src="../../assets/img/avatars/1.png" alt class="rounded-circle" />
                                                        </div>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <span class="fw-semibold d-block lh-1">John Doe</span>
                                                        <small>Admin</small>
                                                    </div>
                                                </div>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-profile-user.html">
                                                <i class="bx bx-user me-2"></i>
                                                <span class="align-middle">My Profile</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-account-settings-account.html">
                                                <i class="bx bx-cog me-2"></i>
                                                <span class="align-middle">Settings</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-account-settings-billing.html">
                                                <span class="d-flex align-items-center align-middle">
                                                    <i class="flex-shrink-0 bx bx-credit-card me-2"></i>
                                                    <span class="flex-grow-1 align-middle">Billing</span>
                                                    <span class="flex-shrink-0 badge badge-center rounded-pill bg-danger w-px-20 h-px-20">4</span>
                                                </span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-help-center-landing.html">
                                                <i class="bx bx-support me-2"></i>
                                                <span class="align-middle">Help</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-faq.html">
                                                <i class="bx bx-help-circle me-2"></i>
                                                <span class="align-middle">FAQ</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="pages-pricing.html">
                                                <i class="bx bx-dollar me-2"></i>
                                                <span class="align-middle">Pricing</span>
                                            </a>
                                        </li>
                                        <li>
                                            <div class="dropdown-divider"></div>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="auth-login-cover.html" target="_blank">
                                                <i class="bx bx-power-off me-2"></i>
                                                <span class="align-middle">Log Out</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>

                <div class="layout-page">
                    <div class="content-wrapper">
                        <x-message type="error" bag="default" />
                        <x-message type="success" bag="default" />

                        <div class="container-xxl flex-grow-1 container-p-y">
                            @yield ('body')
                        </div>

                        <div class="content-backdrop fade"></div>
                    </div>
                </div>
            </div>
        </div>

        @include ('layouts.molecules.footer')
    </body>
</html>

