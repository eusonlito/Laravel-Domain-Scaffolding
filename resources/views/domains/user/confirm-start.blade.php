@extends ('layouts.card')

@section ('body')

<h1 class="h3 mb-4 fw-bold text-center">{{ __('user-confirm-start.header') }}</h1>
<h2 class="h4 mb-2 text-center">{{ __('user-confirm-start.title') }}</h2>
<p class="mb-4 text-center">{!! __('user-confirm-start.message', ['email' => $AUTH->email]) !!}</p>

<x-message type="error" />

<form class="mb-3" method="POST">
    <input type="hidden" name="_action" value="confirmStart" />
    <button class="btn btn-primary d-grid w-100">{{ __('user-confirm-start.send') }}</button>
</form>

@stop
