@extends ('layouts.main')

@section ('body')

<x-message type="error" bag="validate" />

<form method="post">
    <input type="hidden" name="_action" value="signup" />

    <h2>{{ __('user-signup.title') }}</h2>

    <p>
        {{ __('user-signup.description') }}
    </p>

    <label>
        {{ __('user-signup.name') }}
        <input type="text" name="name" placeholder="{{ __('user-signup.name-placeholder') }}" value="{{ $REQUEST->input('name') }}" autofocus required />
    </label>

    <label>
        {{ __('user-signup.email') }}
        <input type="email" name="email" placeholder="{{ __('user-signup.email-placeholder') }}" value="{{ $REQUEST->input('email') }}" required />
    </label>

    <label>
        {{ __('user-signup.password') }}
        <input name="password" type="password" placeholder="{{ __('user-signup.password-placeholder') }}" minlength="8" required />
    </label>

    <label>
        <input name="conditions" type="checkbox" value="1" required />
        {{ __('user-signup.conditions') }}
    </label>

    <button>
        {{ __('user-signup.send') }}
    </button>
</form>

<hr />

<p>
    {!! __('user-signup.auth', ['link' => route('user.auth.credentials')]) !!}
</p>

@stop