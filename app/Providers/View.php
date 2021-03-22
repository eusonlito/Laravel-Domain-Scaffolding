<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class View extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->blade();
    }

    /**
     * @return void
     */
    protected function blade()
    {
        Blade::directive('asset', function (string $path) {
            return "<?= \App\Services\Html\Html::asset($path); ?>";
        });

        Blade::directive('image', function (string $path, string $transform = '') {
            return "<?= \App\Services\Html\Html::image($path, $transform); ?>";
        });

        Blade::directive('datetime', function (string $date) {
            return "<?= date('d/m/Y H:i', strtotime($date)); ?>";
        });

        Blade::directive('number', function (string $value, string $decimals = '2') {
            return "<?= \App\Services\Html\Html::number($value, $decimals); ?>";
        });

        Blade::directive('money', function (string $value, string $decimals = '2') {
            return "<?= \App\Services\Html\Html::money($value, $decimals); ?>";
        });

        Blade::directive('percent', function (string $first, string $second = '') {
            return "<?= \App\Services\Html\Html::percent($first, $second); ?>";
        });

        Blade::directive('query', function (string $query) {
            return "<?= \App\Services\Html\Html::query($query); ?>";
        });
    }
}
