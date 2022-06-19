@extends ('layouts.card')

@section ('body')

<div class="app-brand justify-content-center">
    <span class="h3 mb-0 fw-bold">{{ __('user-disabled.header') }}</span>
</div>

<h4 class="mb-2 text-center">{{ __('user-disabled.title') }}</h4>
<p class="mb-4 text-center">{!! __('user-disabled.message') !!}</p>

@stop
