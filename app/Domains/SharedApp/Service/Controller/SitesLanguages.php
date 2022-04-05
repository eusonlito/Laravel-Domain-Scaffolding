<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Service\Controller;

use Illuminate\Support\Collection;
use App\Domains\Site\Model\SiteLanguage as SiteLanguageModel;
use App\Domains\Url\Model\Url as UrlModel;

class SitesLanguages
{
    /**
     * @var \Illuminate\Support\Collection
     */
    protected Collection $urlsHome;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function handle(): Collection
    {
        return $this->list();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function list(): Collection
    {
        return SiteLanguageModel::list()
            ->get()
            ->each(fn ($value) => $this->listMap($value));
    }

    /**
     * @param \App\Domains\Site\Model\SiteLanguage $siteLanguage
     *
     * @return void
     */
    protected function listMap(SiteLanguageModel $siteLanguage): void
    {
        $siteLanguage->setRelation('url', $this->listMapUrlHome($siteLanguage));
        $siteLanguage->active = false;
    }

    /**
     * @param \App\Domains\Site\Model\SiteLanguage $siteLanguage
     *
     * @return \App\Domains\Url\Model\Url
     */
    protected function listMapUrlHome(SiteLanguageModel $siteLanguage): UrlModel
    {
        return $this->urlsHome()
            ->where('site_id', $siteLanguage->site_id)
            ->firstWhere('language_id', $siteLanguage->language_id)
            ?: new UrlModel(['url' => $siteLanguage->url()]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function urlsHome(): Collection
    {
        return $this->urlsHome ??= UrlModel::whereHome()->get();
    }
}
