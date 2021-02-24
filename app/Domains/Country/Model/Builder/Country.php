<?php declare(strict_types=1);

namespace App\Domains\Country\Model\Builder;

use App\Domains\Shared\Model\Builder\BuilderAbstract;

class Country extends BuilderAbstract
{
    /**
     * @return self
     */
    public function list(): self
    {
        return $this->enabled()->orderBy('default', 'DESC');
    }
}
