<?php declare(strict_types=1);

namespace App\Domains\Configuration\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return void
     */
    public function request(): void
    {
        $this->actionHandle(Request::class);
    }
}
