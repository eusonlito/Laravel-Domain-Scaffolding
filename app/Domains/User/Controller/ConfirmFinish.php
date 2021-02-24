<?php declare(strict_types=1);

namespace App\Domains\User\Controller;

use Illuminate\Http\Response;
use App\Domains\User\Model\User as Model;

class ConfirmFinish extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        $this->meta('title', __('user-confirm-finish.meta-title'));

        return $this->page('user.confirm-finish', [
            'row' => $this->actionCall('confirmFinish'),
        ]);
    }

    /**
     * @return \App\Domains\User\Model\User
     */
    protected function confirmFinish(): Model
    {
        return $this->action($this->auth)->confirmFinish();
    }
}
