<?php declare(strict_types=1);

namespace App\Domains\OPcache\Action;

use App\Domains\Shared\Action\ActionFactoryAbstract;

class ActionFactory extends ActionFactoryAbstract
{
    /**
     * @return array
     */
    public function preload(): array
    {
        return $this->actionHandleTransaction(Preload::class);
    }
}
