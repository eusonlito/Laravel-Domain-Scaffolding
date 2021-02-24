<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Mail;

use App\Domains\Shared\Mail\MailFactoryAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;

class MailFactory extends MailFactoryAbstract
{
    /**
     * @param \App\Domains\UserPasswordReset\Model\UserPasswordReset $row
     * @param \App\Domains\User\Model\User $user
     *
     * @return void
     */
    public function start(Model $row, UserModel $user): void
    {
        $this->queue(new Start($row, $user));
    }
}
