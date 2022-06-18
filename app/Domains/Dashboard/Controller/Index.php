<?php declare(strict_types=1);

namespace App\Domains\Dashboard\Controller;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function __invoke(): Response|RedirectResponse
    {
        $this->meta('title', __('dashboard-index.meta-title'));

        return $this->page('dashboard.index');
    }
}
