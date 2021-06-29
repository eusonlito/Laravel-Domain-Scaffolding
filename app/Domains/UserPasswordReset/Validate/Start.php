<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Start extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => ['bail', 'required', 'email:filter'],
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
        ];
    }
}
