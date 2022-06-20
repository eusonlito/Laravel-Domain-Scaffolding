<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class UpdateApi extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'api_key' => ['bail', 'string'],
            'api_enabled' => ['bail', 'boolean'],
            'password_current' => ['bail', 'required', 'string', 'current_password'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'password_current.required' => __('validator.password_current-required'),
            'password_current.current_password' => __('validator.password_current-current_password'),
        ];
    }
}
