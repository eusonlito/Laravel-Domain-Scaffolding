@extends ('layouts.main')

@section ('body')

<x-message type="error" bag="validate" />

<form method="post">
    <input type="hidden" name="_action" value="updateProfile" />

    <label>
        {{ __('user-update-profile.name') }}
        <input type="text" name="name" placeholder="{{ __('user-update-profile.name-placeholder') }}" value="{{ $REQUEST->input('name') ?: $row->name }}" autofocus required />
    </label>

    <label>
        {{ __('user-update-profile.email') }}
        <input type="email" name="email" placeholder="{{ __('user-update-profile.email-placeholder') }}" value="{{ $REQUEST->input('email') ?: $row->email }}" required />
    </label>

    <label>
        {{ __('user-update-profile.password') }}
        <input name="password" type="password" placeholder="{{ __('user-update-profile.password-placeholder') }}" minlength="8" />
    </label>

    <button type="submit">
        {{ __('user-update-profile.send') }}
    </button>
</form>

<p><a href="{{ route('dashboard.index') }}">{{ __('user-update-profile.dashboard') }}</a></p>

@stop