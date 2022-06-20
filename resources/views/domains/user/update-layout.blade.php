@extends ('layouts.main')

@section ('body')

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <a href="{{ route('user.update.profile') }}" class="nav-link {{ ($ROUTE === 'user.update.profile') ? 'active' : '' }}"><i class="bx bx-user me-1"></i> {{ __('user-update.account') }}</a>
            </li>

            <li class="nav-item">
                <a href="{{ route('user.update.api') }}" class="nav-link {{ ($ROUTE === 'user.update.api') ? 'active' : '' }}"><i class="bx bx-link-alt me-1"></i> {{ __('user-update.api') }}</a>
            </li>
        </ul>

        @yield ('content')
    </div>
</div>

@stop
