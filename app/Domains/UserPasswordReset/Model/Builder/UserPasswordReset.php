<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class UserPasswordReset extends BuilderAbstract
{
    /**
     * @return self
     */
    public function available(): self
    {
        return $this->whereNull(['canceled_at', 'finished_at']);
    }
}
