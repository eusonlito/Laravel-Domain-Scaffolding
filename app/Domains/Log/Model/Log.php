<?php declare(strict_types=1);

namespace App\Domains\Log\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Log\Model\Builder\Log as Builder;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;

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

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::FOREIGN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function userFrom(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, 'user_from_id');
    }
}
