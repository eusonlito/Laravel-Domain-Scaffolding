@extends ('layouts.card')

@section ('body')

<h1 class="h3 mb-4 fw-bold text-center">{{ __('user-confirm-start-success.header') }}</h1>
<h2 class="h4 mb-2 text-center">{{ __('user-confirm-start-success.title') }}</h2>
<p class="mb-4 text-center">{!! __('user-confirm-start-success.message', ['email' => $AUTH->email]) !!}</p>

<x-message type="error" bag="default" />

@stop
