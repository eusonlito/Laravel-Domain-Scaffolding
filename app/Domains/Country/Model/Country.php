<?php declare(strict_types=1);

namespace App\Domains\Country\Model;

use App\Domains\Country\Model\Builder\Country as Builder;
use App\Domains\Shared\Model\ModelAbstract;

class Country extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'country';

    /**
     * @const string
     */
    public const TABLE = 'country';

    /**
     * @const string
     */
    public const FOREIGN = 'country_id';

    /**
     * @return void
     */
    protected static function booted()
    {
        static::addGlobalScope('enabled', static fn (Builder $q) => $q->where(static::TABLE.'.enabled', true));
        static::addGlobalScope('cache', static fn (Builder $q) => $q->cache());
    }

    /**
     * @param \Illuminate\Database\Query\Builder $q
     *
     * @return \Illuminate\Database\Eloquent\Builder|static
     */
    public function newEloquentBuilder($q)
    {
        return new Builder($q);
    }
}
