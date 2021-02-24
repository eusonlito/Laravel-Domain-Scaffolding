@extends ('mail.layout')

@section ('body')

<p style="big">{{ __('user-password-reset-start-mail.title', ['name' => $row->name]) }}</p>
<p>{{ __('user-password-reset-start-mail.message') }}</p>
<a href="{{ $url }}">{{ __('user-password-reset-start-mail.reset') }}</a>
<p style="small">{!! __('user-password-reset-start-mail.error') !!}</p>

@stop
