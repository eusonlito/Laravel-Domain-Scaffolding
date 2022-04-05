<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\View as ViewFacade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\View as ViewView;

class View extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->blade();
        $this->layoutMolecules();
    }

    /**
     * @return void
     */
    protected function blade()
    {
        Blade::directive('asset', function (string $expression) {
            return "<?= \App\Services\Html\Html::asset($expression); ?>";
        });

        Blade::directive('cut', function (string $expression) {
            return "<?= \App\Services\Html\Html::cut($expression); ?>";
        });

        Blade::directive('image', function (string $expression) {
            return "<?= \App\Services\Html\Html::image($expression); ?>";
        });

        Blade::directive('inline', function (string $expression) {
            return "<?= \App\Services\Html\Html::inline($expression); ?>";
        });

        Blade::directive('svg', function (string $expression) {
            return "<?= \App\Services\Html\Html::svg($expression); ?>";
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

        Blade::directive('query', function (string $expression) {
            return "<?= \App\Services\Html\Html::query($expression); ?>";
        });

        Blade::directive('route', function (string $expression) {
            return "<?= \App\Services\Html\Html::route($expression); ?>";
        });

        Blade::directive('url', function (string $expression) {
            return "<?= \App\Services\Html\Html::url($expression); ?>";
        });

        Blade::directive('return', function () {
            return '<?php return; ?>';
        });
    }

    /**
     * @return void
     */
    protected function layoutMolecules()
    {
        ViewFacade::composer('layouts.molecules.header', function (ViewView $view) {
            $view->with(['showMenu' => $view->getData()['page_config']['menu'] ?? true]);
        });

        ViewFacade::composer('layouts.molecules.mobile-menu', function (ViewView $view) {
            $view->with(['showMenu' => $view->getData()['page_config']['menu'] ?? true]);
        });

        ViewFacade::composer('molecules.help-desk-contact', function (ViewView $view) {
            $configuration = app('configuration');
            $view->with([
                'pageTypeCode' => $view->page_type->code,
                'phoneWhatsapp' => $configuration->get('contact_whatsapp')->value ?? null,
            ]);
        });
    }
}
