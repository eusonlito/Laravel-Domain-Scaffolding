<?php declare(strict_types=1);

namespace App\Domains\OPcache\Controller;

use Illuminate\Http\Response;

class Preload extends ControllerAbstract
{
    /**
     * @return \Illuminate\Http\Response
     */
    public function __invoke(): Response
    {
        return response($this->action()->preload());
    }
}
