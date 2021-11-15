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
            'action' => ['bail', 'required', 'string'],
            'related_table' => ['bail', 'required', 'string'],
            'related_id' => ['bail', 'required', 'integer'],
            'payload' => ['bail'],
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'action.required' => __('log-create.validate.action-required'),
            'related_table.required' => __('log-create.validate.related_table-required'),
            'related_id.required' => __('log-create.validate.related_id-required'),
        ];
    }
}
