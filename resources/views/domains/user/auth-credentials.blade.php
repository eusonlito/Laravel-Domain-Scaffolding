@extends ('layouts.main')

@section ('body')

<x-message type="error" bag="validate" />

<h2>{{ __('user-auth-credentials.title') }}</h2>

<form method="post">
    <input type="hidden" name="_action" value="authCredentials" />

    <message type="error" bag="credentials"></message>

    <label>
        {{ __('user-auth-credentials.email') }}
        <input type="email" name="email" value="{{ $REQUEST->input('email') }}" autofocus required />
    </label>

    <label>
        {{ __('user-auth-credentials.password') }}
        <input type="password" name="password" minlength="6" required />
    </label>

    <button>
        {{ __('user-auth-credentials.submit') }}
    </button>
</form>

<hr />

<p>
    {!! __('user-auth-credentials.signup', ['link' => route('user.signup')]) !!}
</p>

@stop