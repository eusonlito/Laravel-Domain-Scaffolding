@extends ('layouts.card')

@section ('body')

<h1 class="h3 mb-4 fw-bold text-center">{{ __('user-confirm-finish.header') }}</h1>

@if ($row)

<h2 class="h4 mb-2 text-center">{{ __('user-confirm-finish.title') }}</h2>
<p class="mb-4 text-center">{!! __('user-confirm-finish.message', ['name' => $row->name]) !!}</p>

<a href="{{ route('dashboard.index') }}" class="btn btn-primary d-grid w-100">{{ __('user-confirm-finish.dashboard') }}</a>

@else

<x-message type="error" bag="default" />

@endif

@stop
