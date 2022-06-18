<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        @include ('layouts.molecules.head')
    </head>

    <body class="body-{{ str_replace('.', '-', $ROUTE) }}">
        <x-message type="error" bag="default" />
        <x-message type="success" bag="default" />

        @yield ('body')

        @include ('layouts.molecules.footer')
    </body>
</html>
