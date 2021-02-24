<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Controller;

use Illuminate\Http\Response;

class Start extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        if ($response = $this->actionPost('start')) {
            return $response;
        }

        $this->meta('title', __('user-password-reset-start.meta-title'));

        return $this->page('user-password-reset.start');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function start(): Response
    {
        $this->action()->start();

        return $this->page('user-password-reset.start-success');
    }
}
