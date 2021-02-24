@extends ('layouts.main')

@section ('body')

<header>
    <h1>{{ $row->translate('title') }}</h1>
</header>

@include ('domains.text.templates.'.$row->template())

@stop