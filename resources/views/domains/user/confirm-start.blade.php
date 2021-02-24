@extends ('layouts.main')

@section ('body')

<form method="post">
    <input type="hidden" name="_action" value="confirmStart" />

    <header>
        <h2>{{ __('user-confirm-start.title') }}</h2>
        <p>{!! __('user-confirm-start.description', ['email' => $AUTH->email]) !!}</p>
    </header>

    <button type="submit">
        {{ __('user-confirm-start.send') }}
    </button>
</form>

@stop