<?php declare(strict_types=1);

namespace App\Domains\User\Mail;

use App\Domains\Shared\Mail\MailFactoryAbstract;
use App\Domains\User\Model\User as Model;

class MailFactory extends MailFactoryAbstract
{
    /**
     * @param \App\Domains\User\Model\User $row
     *
     * @return void
     */
    public function signup(Model $row): void
    {
        $this->queue(new Signup($row));
    }

    /**
     * @param \App\Domains\User\Model\User $row
     *
     * @return void
     */
    public function confirmStart(Model $row): void
    {
        $this->queue(new ConfirmStart($row));
    }
}
