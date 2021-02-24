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
            'table' => 'bail|required|string',
            'action' => 'bail|required|string',
            'contents' => 'bail',
            'person_id' => 'bail|nullable|integer',
            'post_id' => 'bail|nullable|integer',
            'social_id' => 'bail|nullable|integer',
            'tag_id' => 'bail|nullable|integer',
            'user_from_id' => 'bail|nullable|integer',
            'user_id' => 'bail|nullable|integer',
        ];
    }

    /**
     * @return array
     */
    public function messages(): array
    {
        return [
            'table.required' => __('validator.table-required'),
            'action.required' => __('validator.action-required'),
            'person_id.integer' => __('validator.person_id-integer'),
            'post_id.integer' => __('validator.post_id-integer'),
            'social_id.integer' => __('validator.social_id-integer'),
            'tag_id.integer' => __('validator.tag_id-integer'),
            'user_from_id.integer' => __('validator.user_from_id-integer'),
            'user_id.integer' => __('validator.user_id-integer'),
        ];
    }
}
