<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class AuthCredentials extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email:filter'],
            'password' => ['bail', 'required', 'string'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'email.required' => __('validator.email-required'),
            'email.email' => __('validator.email-email'),
            'password.required' => __('validator.password-required'),
        ];
    }
}
