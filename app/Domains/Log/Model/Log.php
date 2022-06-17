<?php declare(strict_types=1);

namespace App\Domains\Log\Model;

use App\Domains\Log\Model\Builder\Log as Builder;
use App\Domains\SharedApp\Model\ModelAbstract;

class Log extends ModelAbstract
{
    /**
     * @var string
     */
    protected $table = 'log';

    /**
     * @const string
     */
    public const TABLE = 'log';

    /**
     * @const string
     */
    public const FOREIGN = 'log_id';

    /**
     * @var array
     */
    protected $casts = [
        'payload' => 'object',
    ];

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
