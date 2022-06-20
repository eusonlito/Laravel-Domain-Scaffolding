<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="body-{{ str_replace('.', '-', $ROUTE) }}">
        <div class="layout-wrapper layout-navbar-full layout-horizontal layout-without-menu">
            <div class="layout-container">
                @include ('layouts.molecules.header')

                <div class="layout-page">
                    <div class="content-wrapper">
                        @include ('layouts.molecules.menu')

                        <div class="container-xxl flex-grow-1 container-p-y">
                            <x-message type="error" />
                            <x-message type="success" />

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
