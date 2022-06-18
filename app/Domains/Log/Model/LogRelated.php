<?php declare(strict_types=1);

namespace App\Domains\Log\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Log\Model\Builder\Log as Builder;
use App\Domains\Log\Model\Traits\Payload as PayloadTrait;
use App\Domains\Shared\Model\ModelAbstract;

class LogRelated extends ModelAbstract
{
    use PayloadTrait;

    /**
     * @var string
     */
    protected $table = 'log_related';

    /**
     * @const string
     */
    public const TABLE = 'log_related';

    /**
     * @const string
     */
    public const FOREIGN = 'log_related_id';

    /**
     * @var array
     */
    protected $casts = [
        'payload' => 'array',
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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function log(): BelongsTo
    {
        return $this->belongsTo(Log::class, Log::FOREIGN);
    }
}
