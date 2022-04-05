<?php declare(strict_types=1);

namespace App\Domains\Log\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Create extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'table' => ['bail', 'required', 'string'],
            'action' => ['bail', 'required', 'string'],
            'payload' => ['bail'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'table.required' => __('log-validate-success.table-required'),
            'action.required' => __('log-validate-success.action-required'),
        ];
    }
}
