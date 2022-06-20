@extends ('domains.user.update-layout')

@section ('content')

<form method="POST">
    <input type="hidden" name="_action" value="updateApi" />

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="user-update-api-api_key" class="form-label">{{ __('user-update-api.api_key') }}</label>

                    <div class="input-group input-group-merge">
                        <input type="password" id="user-update-api-api_key" class="form-control" name="api_key" value="{{ $REQUEST->input('api_key') }}" readonly />

                        <button type="button" class="btn btn-outline-default" data-password-show="#user-update-api-api_key"><i class="bx bx-hide"></i></button>
                        <button type="button" class="btn btn-outline-default" data-copy="#user-update-api-api_key" title="{{ __('user-update-api.api_key-copy') }}"><i class="bx bx-copy"></i></button>
                        <button type="button" class="btn btn-outline-default" data-empty="#user-update-api-api_key" title="{{ __('user-update-api.api_key-regenerate') }}"><i class="bx bx-trash"></i></button>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="user-update-api-api_enabled" class="form-label">&nbsp;</label>

                    <div class="mt-2">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="api_enabled" id="user-update-api-api_enabled" value="1" {{ $REQUEST->input('api_enabled') ? 'checked' : '' }}>
                            <label class="form-check-label" for="user-update-api-api_enabled"> {{ __('user-update-api.api_enabled') }}</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <label for="user-update-api-password_current" class="form-label">{{ __('user-update-api.password_current') }}</label>
            <input type="password" name="password_current" id="user-update-api-password_current" class="form-control" placeholder="{{ __('user-update-api.password_current-placeholder') }}"  required />
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body text-end">
            <a href="{{ route('dashboard.index') }}" class="btn btn-label-secondary me-2">{{ __('user-update-api.cancel') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('user-update-api.save') }}</button>
        </div>
    </div>
</form>

@stop
