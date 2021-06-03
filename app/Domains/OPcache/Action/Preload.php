<?php declare(strict_types=1);

namespace App\Domains\OPcache\Action;

use App\Domains\OPcache\Service\Preloader;

class Preload extends ActionAbstract
{
    /**
     * @return array
     */
    public function handle(): array
    {
        return $this->preload();
    }

    /**
     * @return array
     */
    protected function preload(): array
    {
        return (new Preloader(base_path('')))
            ->paths(
                base_path('app'),
                base_path('vendor/laravel'),
            )
            ->ignore(
                'App\Domains\Shared\Test',
                'Illuminate\Http\Testing',
                'Illuminate\Filesystem\Cache',
                'Illuminate\Foundation\Testing',
                'Illuminate\Testing',
                'PHPUnit',
            )
            ->load()
            ->log();
    }
}
