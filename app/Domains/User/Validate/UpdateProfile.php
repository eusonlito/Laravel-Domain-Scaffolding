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
            'name.required' => __('user-update-profile.validate.name-required'),
            'email.required' => __('user-update-profile.validate.email-required'),
            'email.email' => __('user-update-profile.validate.email-email'),
            'password.min' => __('user-update-profile.validate.password-min', ['length' => 8]),
        ];
    }
}
