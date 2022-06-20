@extends ('domains.user.update-layout')

@section ('content')

<form method="POST">
    <input type="hidden" name="_action" value="updateProfile" />

    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="user-update-profile-name" class="form-label">{{ __('user-update-profile.name') }}</label>
                    <input type="text" name="name" id="user-update-profile-name" class="form-control" placeholder="{{ __('user-update-profile.name-placeholder') }}" value="{{ $REQUEST->input('name') }}" required />
                </div>

                <div class="mb-3 col-md-6">
                    <label for="user-update-profile-email" class="form-label">{{ __('user-update-profile.email') }}</label>
                    <input type="text" name="email" id="user-update-profile-email" class="form-control" placeholder="{{ __('user-update-profile.email-placeholder') }}" value="{{ $REQUEST->input('email') }}" required />
                </div>
            </div>

            <div class="row">
                <div class="mb-3 col-md-6">
                    <label for="user-update-profile-password" class="form-label">{{ __('user-update-profile.password') }}</label>

                    <div class="input-group input-group-merge">
                        <input type="password" id="user-update-profile-password" class="form-control" name="password" placeholder="{{ __('user-update-profile.password-placeholder') }}" minlength="8" />
                        <button type="button" class="btn btn-outline-default" data-password-show="#user-update-profile-password"><i class="bx bx-hide"></i></button>
                    </div>
                </div>

                <div class="col-md-6">
                    <x-select name="timezone" :options="$timezones" value="zone" :text="['gmt', 'zone']" :label="__('user-update-profile.timezone')" required></x-select>
                </div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <label for="user-update-profile-password_current" class="form-label">{{ __('user-update-profile.password_current') }}</label>
            <input type="password" name="password_current" id="user-update-profile-password_current" class="form-control" placeholder="{{ __('user-update-profile.password_current-placeholder') }}"  required />
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body text-end">
            <a href="{{ route('dashboard.index') }}" class="btn btn-label-secondary me-2">{{ __('user-update-profile.cancel') }}</a>
            <button type="submit" class="btn btn-primary">{{ __('user-update-profile.save') }}</button>
        </div>
    </div>
</form>

@stop
