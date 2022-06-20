<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class ConfirmStart extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        if ($this->auth->confirmed_at) {
            return redirect()->route('dashboard.index');
        }

        $this->meta('title', __('user-confirm-start.meta-title'));

        if ($response = $this->actionPost('confirmStart')) {
            return $response;
        }

        return $this->page('user.confirm-start');
    }

    /**
     * @return \Illuminate\Http\Response
     */
    protected function confirmStart(): Response
    {
        $this->action($this->auth)->confirmStart();

        return $this->page('user.confirm-start-success');
    }
}
