<?php declare(strict_types=1);

namespace App\Domains\User\Mail;

use App\Domains\User\Model\User as Model;

class Signup extends MailAbstract
{
    /**
     * @var \App\Domains\User\Model\User
     */
    public Model $row;

    /**
     * @var string
     */
    public string $url = '';

    /**
     * @var string
     */
    public $view = 'domains.user.mail.signup';

    /**
     * @param \App\Domains\User\Model\User $row
     *
     * @return self
     */
    public function __construct(Model $row)
    {
        $this->locale($row->language->iso);
        $this->to($row->email);

        $this->subject = __('user-signup-mail.subject');
        $this->row = $row;
        $this->url = route('user.confirm.finish', $row->idHash());
    }
}
