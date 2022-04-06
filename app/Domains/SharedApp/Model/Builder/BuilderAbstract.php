<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract as BuilderAbstractShared;

abstract class BuilderAbstract extends BuilderAbstractShared
{
    /**
     * @param string $key
     * @param string $mode = 'ASC'
     *
     * @return self
     */
    public function orderByContent(string $key, string $mode = 'ASC'): self
    {
        return $this->orderBy($this->getTable().'.content->'.$key, $mode);
    }

    /**
     * @param string $key
     * @param string $mode = 'ASC'
     *
     * @return self
     */
    public function orderByTranslation(string $key, string $mode = 'ASC'): self
    {
        return $this->orderBy($this->getTable().'.translation->'.app('language')->locale.'->'.$key, $mode);
    }
}
