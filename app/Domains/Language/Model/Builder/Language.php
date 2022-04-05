<?php declare(strict_types=1);

namespace App\Domains\Language\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;
use App\Domains\Site\Model\SiteLanguage as SiteLanguageModel;

class Language extends BuilderAbstract
{
    /**
     * @param string $code
     *
     * @return self
     */
    public function byCode(string $code): self
    {
        return $this->where('code', $code);
    }

    /**
     * @param int $module_id
     *
     * @return self
     */
    public function byModuleId(int $module_id): self
    {
        return $this->whereIn('id', SiteLanguageModel::select('language_id')->byModuleId($module_id));
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('default', 'DESC')->orderBy('name', 'ASC');
    }

    /**
     * @param bool $default = true
     *
     * @return self
     */
    public function whereDefault(bool $default = true): self
    {
        return $this->where('default', $default);
    }
}
