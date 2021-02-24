<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Controller;

use Illuminate\Http\RedirectResponse;

class Finish extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        if ($response = $this->actionPost('finish')) {
            return $response;
        }

        $this->meta('title', __('user-password-reset-finish.meta-title'));

        return $this->page('user-password-reset.finish');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function finish(): RedirectResponse
    {
        $this->action()->finish();
        $this->sessionMessage('success', __('user-password-reset-finish.success'));

        return redirect()->route('user.auth.credentials');
    }
}
