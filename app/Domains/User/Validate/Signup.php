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
            'name' => ['bail', 'required', 'string'],
            'email' => ['bail', 'required', 'email:filter', 'disposable_email', 'unique:user,email'],
            'password' => ['bail', 'required', 'min:8'],
            'conditions' => ['required'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => __('user-validate-signup.name-required'),
            'email.required' => __('user-validate-signup.email-required'),
            'email.email' => __('user-validate-signup.email-email'),
            'email.disposable_email' => __('user-validate-signup.email-disposable_email'),
            'email.unique' => __('user-validate-signup.email-unique'),
            'password.required' => __('user-validate-signup.password-required'),
            'password.min' => __('user-validate-signup.password-min', ['length' => 8]),
            'conditions.required' => __('user-validate-signup.conditions-required'),
        ];
    }
}
