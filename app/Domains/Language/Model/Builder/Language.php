<?php declare(strict_types=1);

namespace App\Domains\Language\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

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
     * @param bool $default = true
     *
     * @return self
     */
    public function whereDefault(bool $default = true): self
    {
        return $this->where($default, $default);
    }
}
