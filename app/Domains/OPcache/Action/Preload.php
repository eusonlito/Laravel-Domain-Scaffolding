<?php declare(strict_types=1);

namespace App\Domains\OPcache\Action;

use App\Domains\OPcache\Service\Preloader;

class Preload extends ActionAbstract
{
    /**
     * @return void
     */
    public function handle(): void
    {
        $this->preload();
    }

    /**
     * @return void
     */
    protected function preload(): void
    {
        (new Preloader(base_path('')))
            ->paths(
                base_path('app'),
                base_path('vendor/laravel'),
            )
            ->ignore(
                'Illuminate\Http\Testing',
                'Illuminate\Filesystem\Cache',
                'Illuminate\Foundation\Testing',
                'Illuminate\Testing',
                'PHPUnit',
            )
            ->load();
    }
}
