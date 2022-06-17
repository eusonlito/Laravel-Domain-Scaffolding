<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Controller;

use Illuminate\Support\Collection;
use App\Domains\Cart\Model\Cart as CartModel;
use App\Domains\Language\Model\Language as LanguageModel;
use App\Domains\Shared\Controller\ControllerWebAbstract as ControllerWebAbstractShared;
use App\Domains\SharedApp\Service\Controller\SitesLanguages as SitesLanguagesService;
use App\Domains\Site\Model\Site as SiteModel;
use App\Domains\Site\Model\SiteLanguage as SiteLanguageModel;
use App\Domains\Url\Model\Url as UrlModel;

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
