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
            'timezone' => ['bail', 'string', 'required'],
            'password' => ['bail', 'string', 'min:8'],
            'password_current' => ['bail', 'required', 'string', 'current_password'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => __('validator.name-required'),
            'email.required' => __('validator.email-required'),
            'email.email' => __('validator.email-email'),
            'timezone.required' => __('validator.timezone-required'),
            'password.min' => __('validator.password-min', ['length' => 8]),
            'password_current.required' => __('validator.password_current-required'),
            'password_current.current_password' => __('validator.password_current-current_password'),
        ];
    }
}
