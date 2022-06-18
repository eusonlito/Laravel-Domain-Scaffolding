<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Signup extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'timezone' => ['bail', 'string'],
            'name' => ['bail', 'required', 'string'],
            'email' => ['bail', 'required', 'string', 'email:filter', 'disposable_email'],
            'password' => ['bail', 'required', 'string', 'min:8'],
            'conditions' => ['required'],
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
            'email.disposable_email' => __('validator.email-disposable_email'),
            'password.required' => __('validator.password-required'),
            'password.min' => __('validator.password-min', ['length' => 8]),
            'conditions.required' => __('validator.conditions-required'),
        ];
    }
}
