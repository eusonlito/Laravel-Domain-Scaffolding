<?php declare(strict_types=1);

namespace App\Domains\Error\Controller;

use Throwable;
use Illuminate\Http\Response;

class Index extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Throwable $e): Response
    {
        $this->meta('title', __('error.meta-title'));

        return $this->page('error.index', [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ], $e->getCode());
    }
}
