<?php declare(strict_types=1);

namespace App\Domains\User\Validate;

use App\Domains\Shared\Validate\ValidateFactoryAbstract;

class ValidateFactory extends ValidateFactoryAbstract
{
    /**
     * @return array
     */
    public function authCredentials(): array
    {
        return $this->handle(AuthCredentials::class);
    }

    /**
     * @return array
     */
    public function confirmFinish(): array
    {
        return $this->handle(ConfirmFinish::class);
    }

    /**
     * @return array
     */
    public function signup(): array
    {
        return $this->handle(Signup::class);
    }

    /**
     * @return array
     */
    public function updateProfile(): array
    {
        return $this->handle(UpdateProfile::class);
    }
}
