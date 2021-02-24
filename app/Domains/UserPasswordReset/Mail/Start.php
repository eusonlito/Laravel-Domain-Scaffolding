<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Mail;

use App\Domains\Shared\Mail\MailAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;

class Start extends MailAbstract
{
    /**
     * @var \App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    public Model $row;

    /**
     * @var \App\Domains\User\Model\User
     */
    public UserModel $user;

    /**
     * @var string
     */
    public string $url = '';

    /**
     * @var string
     */
    public $view = 'domains.user-password-reset.mail.start';

    /**
     * @param \App\Domains\UserPasswordReset\Model\UserPasswordReset $row
     * @param \App\Domains\User\Model\User $user
     *
     * @return self
     */
    public function __construct(Model $row, UserModel $user)
    {
        $this->locale($user->language->iso);
        $this->to($user->email);

        $this->subject = __('user-password-reset-start-mail.subject');
        $this->row = $row;
        $this->user = $user;
        $this->url = route('user-password-reset.finish', $row->hash);
    }
}
