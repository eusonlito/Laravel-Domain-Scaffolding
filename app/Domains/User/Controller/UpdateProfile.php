<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;

class UpdateProfile extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke()
    {
        $this->meta('title', __('user-update-profile.meta-title'));

        if ($response = $this->actionPost('updateProfile')) {
            return $response;
        }

        return $this->page('user.update-profile', [
            'row' => $this->auth,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateProfile(): RedirectResponse
    {
        $this->action($this->auth)->updateProfile();

        return redirect()->route('user.update.profile');
    }
}
