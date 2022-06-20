<?php declare(strict_types=1);

namespace App\Domains\User\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class User extends BuilderAbstract
{
    /**
     * @param string $api_key
     *
     * @return self
     */
    public function byApiKey(string $api_key): self
    {
        return $this->where('api_key', $api_key);
    }

    /**
     * @param string $email
     *
     * @return self
     */
    public function byEmail(string $email): self
    {
        return $this->where('email', $email);
    }
}
