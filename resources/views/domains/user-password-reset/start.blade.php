@extends ('layouts.main')

@section ('body')

<form method="post">
    <input type="hidden" name="_action" value="start" />

    <h2>{{ __('user-password-reset-start.title') }}</h2>
    <p>{!! __('user-password-reset-start.intro') !!}</p>

    <label>
        <input type="email" name="email" value="{{ $REQUEST->input('email') }}" autofocus required />
        {{ __('user-password-reset-start.email') }}
    </label>

    <button>
        {{ __('user-password-reset-start.send') }}
    </button>
</form>

@stop