@extends ('layouts.main')

@section ('body')

<form method="post">
    <input type="hidden" name="_action" value="finish" />

    <header>
        <h2>{{ __('user-password-reset-finish.title') }}</h2>
        <p>{!! __('user-password-reset-finish.intro') !!}</p>
    </header>

    <label>
        <input type="password" name="password" placeholder="************" minlength="8" autofocus required />
        {{ __('user-password-reset-finish.password') }}
    </label>

    <button>
        {{ __('user-password-reset-finish.send') }}
    </button>
</form>

@stop