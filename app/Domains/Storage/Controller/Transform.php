<?php declare(strict_types=1);

namespace App\Domains\Storage\Controller;

use Symfony\Component\HttpFoundation\StreamedResponse;

class Transform extends ControllerAbstract
{
    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function __invoke(): StreamedResponse
    {
        return $this->action()->transform();
    }
}
