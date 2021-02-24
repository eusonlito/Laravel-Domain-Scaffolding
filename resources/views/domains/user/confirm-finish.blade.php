@extends ('layouts.main')

@section ('body')

@if ($row)

<header>
    <h2>{{ __('user-confirm-finish.welcome', ['name' => $row->name]) }}</h2>
</header>

<div>
    <a href="{{ route('dashboard.index') }}">
        {{ __('user-confirm-finish.go') }}
    </a>
</div>

@else

<div>🤷</div>

@endif

@stop