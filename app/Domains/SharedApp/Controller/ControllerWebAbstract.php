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
     * @var \Illuminate\Support\Collection
     */
    protected Collection $initCustomSitesLanguages;

    /**
     * @var \App\Domains\Site\Model\SiteLanguage
     */
    protected SiteLanguageModel $initCustomSiteLanguage;

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
            'sites_languages' => $this->initCustomSitesLanguages(),
            'site_language' => $this->initCustomSiteLanguage(),
            'site' => $this->initCustomSite(),
            'language' => $this->initCustomLanguage(),
            'url_country' => null,
            'admin' => false,

            'url' => null,
            'page' => null,
            'page_group' => null,
            'page_type' => null,
            'modules' => [],
            'page_config' => [],

            'cart' => $this->initCustomCart(),

            'env' => $this->initCustomEnv(),
            'configuration' => $this->initCustomConfiguration(),

            'home' => $this->initCustomHome(),
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function initCustomSitesLanguages(): Collection
    {
        return $this->initCustomSitesLanguages ??= SitesLanguagesService::new()->handle();
    }

    /**
     * @return \App\Domains\Site\Model\SiteLanguage
     */
    protected function initCustomSiteLanguage(): SiteLanguageModel
    {
        return $this->initCustomSiteLanguage ??= $this->initCustomSitesLanguages()
            ->where('site_id', app('site')->id)
            ->firstWhere('language_id', app('language')->id);
    }

    /**
     * @return \App\Domains\Site\Model\Site
     */
    protected function initCustomSite(): SiteModel
    {
        return $this->initCustomSiteLanguage()->site;
    }

    /**
     * @return \App\Domains\Language\Model\Language
     */
    protected function initCustomLanguage(): LanguageModel
    {
        return $this->initCustomSiteLanguage()->language;
    }

    /**
     * @return \App\Domains\Url\Model\Url
     */
    protected function initCustomHome(): UrlModel
    {
        return $this->initCustomSiteLanguage()->url;
    }

    /**
     * @return \App\Domains\Cart\Model\Cart
     */
    protected function initCustomCart(): CartModel
    {
        return CartModel::bySession($this->request->session()->getId())
            ->withItems()
            ->firstOrNew()
            ->setUrl();
    }

    /**
     * @return void
     */
    protected function initCustomMetas(): void
    {
        $siteLanguage = $this->initCustomSiteLanguage();

        $this->meta('title', $siteLanguage->translation('title'));
        $this->meta('description', $siteLanguage->translation('meta.description'));
        $this->meta('keywords', $siteLanguage->translation('meta.keywords'));
        $this->meta('image', $siteLanguage->content('image'));
    }

    /**
     * @return array
     */
    protected function initCustomEnv(): array
    {
        return [
            'site' => $this->initCustomSite()->only('id'),
            'language' => $this->initCustomLanguage()->only('id', 'locale'),
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
