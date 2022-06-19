@extends ('mail.layout')

@section ('body')

<p class="big">{{ __('user-confirm-start-mail.title', ['user' => $row->name]) }}</p>
<p>{!! __('user-confirm-start-mail.message') !!}</p>
<a href="{{ $url }}">{{ __('user-confirm-start-mail.confirm') }}</a>

@stop
