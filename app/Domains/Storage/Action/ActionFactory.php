<?php declare(strict_types=1);

namespace App\Domains\Storage\Action;

use Symfony\Component\HttpFoundation\StreamedResponse;
use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function transform(): StreamedResponse
    {
        return $this->actionHandle(Transform::class, $this->validate()->transform());
    }
}
