@extends ('layouts.card')

@section ('body')

<h1 class="h3 mb-4 fw-bold text-center">{{ __('user-auth-credentials.header') }}</h1>
<h2 class="h4 mb-4 text-center">{{ __('user-auth-credentials.title') }}</h2>

<x-message type="error" />

<form class="mb-3" method="POST">
    <input type="hidden" name="_action" value="authCredentials" />

    <div class="mb-3">
        <label for="user-auth-credentials-email" class="form-label">{{ __('user-auth-credentials.email') }}</label>
        <input type="email" class="form-control" id="user-auth-credentials-email" name="email" value="{{ $REQUEST->input('email') }}" placeholder="{{ __('user-auth-credentials.email-placeholder') }}" />
    </div>

    <div class="mb-3 form-password-toggle">
        <label class="form-label" for="user-auth-credentials-password">{{ __('user-auth-credentials.password') }}</label>
        <input type="password" id="user-auth-credentials-password" class="form-control" name="password" placeholder="{{ __('user-auth-credentials.password-placeholder') }}" minlength="8" aria-describedby="password" />
    </div>

    <button class="btn btn-primary d-grid w-100">{{ __('user-auth-credentials.signin') }}</button>
</form>

<p class="text-center">
    <span>{{ __('user-auth-credentials.no-account') }}</span>

    <a href="{{ route('user.signup') }}">
        <span>{{ __('user-auth-credentials.signup') }}</span>
    </a>
</p>

@stop
