@extends ('layouts.main')

@section ('body')

<div class="row">
    <div class="col-md-12">
        <ul class="nav nav-pills flex-column flex-md-row mb-3">
            <li class="nav-item">
                <a class="nav-link active" href="javascript:void(0);"><i class="bx bx-user me-1"></i> {{ __('user-update-profile.account') }}</a>
            </li>
        </ul>

        <div class="card mb-4">
            <div class="card-body">
                <form method="POST">
                    <input type="hidden" name="_action" value="updateProfile" />

                    <div class="row">
                        <div class="mb-3 col-md-6">
                            <label for="user-update-profile-name" class="form-label">{{ __('user-update-profile.name') }}</label>
                            <input type="text" name="name" id="user-update-profile-name" class="form-control" placeholder="{{ __('user-update-profile.name-placeholder') }}" value="{{ $REQUEST->input('name') }}" autofocus required />
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
                                <span class="input-group-text cursor-pointer" data-password-show="#user-update-profile-password"><i class="bx bx-hide"></i></span>
                            </div>
                        </div>

                        <div class="mb-3 col-md-6">
                            <x-select name="timezone" :options="$timezones" value="zone" :text="['gmt', 'zone']" :label="__('user-update-profile.timezone')" required></x-select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="mb-3 col-md-12">
                            <label for="user-update-profile-password_current" class="form-label">{{ __('user-update-profile.password_current') }}</label>
                            <input type="password" name="password_current" id="user-update-profile-password_current" class="form-control" placeholder="{{ __('user-update-profile.password_current-placeholder') }}"  required />
                        </div>
                    </div>

                    <div class="mt-2">
                        <button type="submit" class="btn btn-primary me-2">{{ __('user-update-profile.save') }}</button>
                        <a href="{{ route('dashboard.index') }}" class="btn btn-label-secondary">{{ __('user-update-profile.cancel') }}</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@stop
