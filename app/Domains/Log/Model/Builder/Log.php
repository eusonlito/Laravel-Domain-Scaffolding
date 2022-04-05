<?php declare(strict_types=1);

namespace App\Domains\Log\Model\Builder;

use App\Domains\SharedApp\Model\Builder\BuilderAbstract;

class Log extends BuilderAbstract
{
    /**
     * @param string $table
     *
     * @return self
     */
    public function byTable(string $table): self
    {
        return $this->where('table', $table);
    }

    /**
     * @return self
     */
    public function list(): self
    {
        return $this->orderBy('id', 'DESC');
    }
}
