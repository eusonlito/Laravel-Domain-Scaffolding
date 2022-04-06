<?php declare(strict_types=1);

namespace App\Domains\Storage\Validate;

use App\Domains\Shared\Validate\ValidateAbstract;

class Transform extends ValidateAbstract
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'file' => ['bail', 'string'],
            'transform' => ['bail', 'string'],
            'hash' => ['bail', 'string'],
        ];
    }
}
