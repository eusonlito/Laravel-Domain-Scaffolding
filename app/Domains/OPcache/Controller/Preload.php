<?php declare(strict_types=1);

namespace App\Domains\OPcache\Controller;

class Preload extends ControllerAbstract
{
    /**
     * @return void
     */
    public function __invoke(): void
    {
        $this->action()->preload();
    }
}
