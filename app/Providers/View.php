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

        Blade::directive('date', function (string $date, string $format = 'd/m/Y H:i') {
            return "<?= date($format, strtotime($date)); ?>";
        });

        Blade::directive('image', function (string $path, string $transform = '') {
            return "<?= \App\Services\Html\Html::image($path, $transform); ?>";
        });

        Blade::directive('number', function (string $value, string $decimals = '4') {
            return "<?= \App\Services\Html\Html::number($value, $decimals); ?>";
        });

        Blade::directive('money', function (string $value, string $decimals = '4') {
            return "<?= \App\Services\Html\Html::money($value, $decimals); ?>";
        });

        Blade::directive('query', function (string $query) {
            return "<?= \App\Services\Html\Html::query($query); ?>";
        });
    }
}
