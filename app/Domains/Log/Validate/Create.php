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
            'class' => ['bail', 'string'],
            'action' => ['bail', 'string', 'required_without:class'],
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
            'action.required_without' => __('log-create.validate.action-required_without'),
            'related_table.required' => __('log-create.validate.related_table-required'),
            'related_id.required' => __('log-create.validate.related_id-required'),
        ];
    }
}
