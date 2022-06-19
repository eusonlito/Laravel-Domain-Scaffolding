<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="body-{{ str_replace('.', '-', $ROUTE) }}">
        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner py-4">
                    <div class="card">
                        <div class="card-body">
                            @yield ('body')
                        </div>
                    </div>
                </div>
            </div>
        </div>

        @include ('layouts.molecules.footer')
    </body>
</html>
