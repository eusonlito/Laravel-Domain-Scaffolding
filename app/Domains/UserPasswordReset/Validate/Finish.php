<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Finish extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'hash' => ['bail', 'required', 'string'],
            'password' => ['bail', 'required', 'min:8'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'hash.required' => __('user-password-reset-finish.validate.hash-required'),
            'password.required' => __('user-password-reset-finish.validate.password-required'),
            'password.min' => __('user-password-reset-finish.validate.password-min', ['length' => 8]),
        ];
    }
}
