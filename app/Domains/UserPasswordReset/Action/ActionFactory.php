<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Action;

use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @var ?\App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    protected ?Model $row;

    /**
     * @return \App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    public function finish(): Model
    {
        return $this->actionHandle(Finish::class, $this->validate()->finish());
    }

    /**
     * @return \App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    public function start(): Model
    {
        return $this->actionHandle(Start::class, $this->validate()->start());
    }
}
