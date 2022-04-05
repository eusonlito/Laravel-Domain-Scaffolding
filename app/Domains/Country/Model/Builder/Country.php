<?php declare(strict_types=1);

namespace App\Domains\Country\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Country extends BuilderAbstract
{
    /**
     * @return self
     */
    public function list(): self
    {
        return $this->select('country.id', 'country.code', 'country.name')
            ->orderBy('default', 'DESC')
            ->orderBy('name', 'ASC');
    }
}
