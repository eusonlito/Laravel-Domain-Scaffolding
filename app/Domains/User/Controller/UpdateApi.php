<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class UpdateApi extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $this->meta('title', __('user-update-api.meta-title'));

        if ($response = $this->actionPost('updateApi')) {
            return $response;
        }

        $this->requestMergeWithRow(row: $this->auth);

        return $this->page('user.update-api', [
            'row' => $this->auth,
        ]);
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function updateApi(): RedirectResponse
    {
        $this->action($this->auth)->updateApi();
        $this->sessionMessage('success', __('user-update-api.success'));

        return redirect()->route('user.update.api');
    }
}
