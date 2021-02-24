<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\User\Model\User as UserModel;
use App\Domains\UserPasswordReset\Model\Builder\UserPasswordReset as Builder;
use App\Domains\UserPasswordReset\Test\Factory\UserPasswordReset as TestFactory;

class UserPasswordReset extends ModelAbstract
{
    use HasFactory;

    /**
     * @var string
     */
    protected $table = 'user_password_reset';

    /**
     * @var string
     */
    public static string $foreign = 'user_password_reset_id';

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
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return TestFactory::new();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(UserModel::class, UserModel::$foreign);
    }
}
