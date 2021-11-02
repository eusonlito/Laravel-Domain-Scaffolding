<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateProfile extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['bail', 'required'],
            'email' => ['bail', 'required', 'email:filter', 'disposable_email'],
            'password' => ['bail', 'min:8'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => __('user-validate-update-profile.name-required'),
            'email.required' => __('user-validate-update-profile.email-required'),
            'email.email' => __('user-validate-update-profile.email-email'),
            'password.min' => __('user-validate-update-profile.password-min', ['length' => 8]),
        ];
    }
}
