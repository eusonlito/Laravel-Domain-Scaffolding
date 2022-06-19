@extends ('mail.layout')

@section ('body')

<p class="big">{{ __('user-signup-mail.title', ['name' => $row->name]) }}</p>
<p>{{ __('user-signup-mail.message') }}</p>
<a href="{{ $url }}">{{ __('user-signup-mail.confirm') }}</a>
<p class="small">{{ __('user-signup-mail.deleted') }}</p>

@stop
