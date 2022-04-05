<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract as BuilderAbstractShared;

abstract class BuilderAbstract extends BuilderAbstractShared
{
    /**
     * @param string $column
     * @param string $mode = 'ASC'
     *
     * @return self
     */
    public function orderByTranslation(string $column, string $mode = 'ASC'): self
    {
        return $this->orderBy($this->getTable().'.translation->'.app('language')->locale.'->'.$column, $mode);
    }

    /**
     * @return self
     */
    public function related(): self
    {
        return $this;
    }
}
