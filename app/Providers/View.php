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
        Blade::directive('asset', function (string $expression) {
            return "<?= \App\Services\Html\Html::asset($expression); ?>";
        });

        Blade::directive('image', function (string $expression) {
            return "<?= \App\Services\Html\Html::image($expression); ?>";
        });

        Blade::directive('datetime', function (string $expression) {
            return "<?= helper()->dateLocal($expression); ?>";
        });

        Blade::directive('number', function (string $expression) {
            return "<?= \App\Services\Html\Html::number($expression); ?>";
        });

        Blade::directive('money', function (string $expression) {
            return "<?= \App\Services\Html\Html::money($expression); ?>";
        });

        Blade::directive('percent', function (string $expression) {
            return "<?= \App\Services\Html\Html::percent($expression); ?>";
        });

        Blade::directive('status', function (string $expression) {
            return "<?= \App\Services\Html\Html::status($expression); ?>";
        });

        Blade::directive('query', function (string $expression) {
            return "<?= \App\Services\Html\Html::query($expression); ?>";
        });
    }
}
