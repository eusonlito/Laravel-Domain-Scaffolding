<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use App\Domains\Country\Model\Country as CountryModel;

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

        $this->requestMergeWithRow(row: $this->auth);

        return $this->page('user.update-profile', [
            'row' => $this->auth,
            'timezones' => helper()->timezones(),
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateProfile(): RedirectResponse
    {
        $this->action($this->auth)->updateProfile();
        $this->sessionMessage('success', __('user-update-profile.success'));

        return redirect()->route('user.update.profile');
    }
}
