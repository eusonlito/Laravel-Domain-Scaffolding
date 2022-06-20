@extends ('layouts.card')

@section ('body')

<h1 class="h3 mb-4 fw-bold text-center">{{ __('user-signup.header') }}</h1>
<h2 class="h4 mb-2 text-center">{{ __('user-signup.title') }}</h2>
<p class="mb-4 text-center">{{ __('user-signup.message') }}</p>

<x-message type="error" />

<form class="mb-3" method="POST">
    <input type="hidden" name="_action" value="signup" />
    <input type="hidden" name="timezone" value="" data-timezone />

    <div class="mb-3">
        <label for="user-signup-name" class="form-label">{{ __('user-signup.name') }}</label>
        <input type="text" class="form-control" id="user-signup-name" name="name" value="{{ $REQUEST->input('name') }}" placeholder="{{ __('user-signup.name-placeholder') }}" autofocus />
    </div>

    <div class="mb-3">
        <label for="user-signup-email" class="form-label">{{ __('user-signup.email') }}</label>
        <input type="email" class="form-control" id="user-signup-email" name="email" value="{{ $REQUEST->input('email') }}" placeholder="{{ __('user-signup.email-placeholder') }}" />
    </div>

    <div class="mb-3 form-password-toggle">
        <label class="form-label" for="user-signup-password">{{ __('user-signup.password') }}</label>

        <div class="input-group input-group-merge">
            <input type="password" id="user-signup-password" class="form-control" name="password" placeholder="{{ __('user-signup.password-placeholder') }}" minlength="8" />
            <span class="input-group-text cursor-pointer" data-password-show="#user-signup-password"><i class="bx bx-hide"></i></span>
        </div>
    </div>

    <div class="mb-3">
        <div class="form-check">
            <input class="form-check-input" type="checkbox" id="user-signup-terms-conditions" name="conditions" required />

            <label class="form-check-label" for="user-signup-terms-conditions">
                {!! __('user-signup.terms-conditions', ['link' => '#']) !!}
            </label>
        </div>
    </div>

    <button class="btn btn-primary d-grid w-100">{{ __('user-signup.signup') }}</button>
</form>

<p class="text-center">
    <span>{{ __('user-signup.already-account') }}</span>

    <a href="{{ route('user.auth.credentials') }}">
        <span>{{ __('user-signup.signin') }}</span>
    </a>
</p>

@stop
