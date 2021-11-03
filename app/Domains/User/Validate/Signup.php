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
            'name.required' => __('user-signup.validate.name-required'),
            'email.required' => __('user-signup.validate.email-required'),
            'email.email' => __('user-signup.validate.email-email'),
            'email.disposable_email' => __('user-signup.validate.email-disposable_email'),
            'email.unique' => __('user-signup.validate.email-unique'),
            'password.required' => __('user-signup.validate.password-required'),
            'password.min' => __('user-signup.validate.password-min', ['length' => 8]),
            'conditions.required' => __('user-signup.validate.conditions-required'),
        ];
    }
}
