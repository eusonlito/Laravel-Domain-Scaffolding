<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Controller;

use App\Domains\Shared\Controller\ControllerWebAbstract as ControllerWebAbstractShared;

abstract class ControllerWebAbstract extends ControllerWebAbstractShared
{
    /**
     * @return void
     */
    protected function initCustom(): void
    {
        $this->initCustomViewShare();
        $this->initCustomMetas();
    }

    /**
     * @return void
     */
    protected function initCustomViewShare(): void
    {
        view()->share($this->initCustomViewShareData());
    }

    /**
     * @return array
     */
    protected function initCustomViewShareData(): array
    {
        return [
            'configuration' => $this->initCustomConfiguration(),
        ];
    }

    /**
     * @return array
     */
    protected function initCustomConfiguration(): array
    {
        return app('configuration')->where('public', true)->pluck('value', 'key')->all();
    }
}
