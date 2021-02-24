<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class ConfirmFinish extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'hash' => 'bail|required|string',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'hash.required' => __('validator.hash-required'),
        ];
    }
}
