<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Validate;

use App\Domains\Shared\Validate\ValidateFactoryAbstract;

class ValidateFactory extends ValidateFactoryAbstract
{
    /**
     * @return array
     */
    public function finish(): array
    {
        return $this->handle(Finish::class);
    }

    /**
     * @return array
     */
    public function start(): array
    {
        return $this->handle(Start::class);
    }
}
