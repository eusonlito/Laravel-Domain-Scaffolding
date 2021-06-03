<?php declare(strict_types=1);

namespace App\Domains\OPcache\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return void
     */
    public function preload(): void
    {
        $this->actionHandleTransaction(Preload::class);
    }
}
