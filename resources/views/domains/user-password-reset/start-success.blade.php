@extends ('layouts.main')

@section ('body')

<h2>{{ __('user-password-reset-start-success.title') }}</h2>
<p>{!! __('user-password-reset-start-success.intro') !!}</p>

<a href="{{ route('user.auth.credentials') }}">
    {{ __('user-password-reset-start-success.auth') }}
</a>

@stop