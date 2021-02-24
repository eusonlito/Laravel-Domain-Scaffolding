@extends ('mail.layout')

@section ('body')

<p style="big">{{ __('user-signup-mail.title', ['name' => $row->name]) }}</p>
<p>{{ __('user-signup-mail.message') }}</p>
<a href="{{ $url }}">{{ __('user-signup-mail.confirm') }}</a>
<p style="small">{{ __('user-signup-mail.deleted') }}</p>

@stop