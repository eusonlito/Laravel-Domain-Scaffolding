<?php declare(strict_types=1);

namespace App\Domains\Shared\Model;

use DateTime;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use App\Domains\Shared\Model\Traits\DateDisabled as DateDisabledTrait;
use App\Domains\Shared\Model\Traits\MutatorDisabled as MutatorDisabledTrait;
use App\Domains\Shared\Model\Traits\QueryBuilderCache as QueryBuilderCacheTrait;

abstract class ModelAbstract extends Model
{
    use DateDisabledTrait, MutatorDisabledTrait, QueryBuilderCacheTrait;

    /**
     * @var bool
     */
    public static $snakeAttributes = false;

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * @param string $column
     *
     * @return \DateTime
     */
    public function datetime(string $column): DateTime
    {
        return new DateTime($this->$column);
    }

    /**
     * @return \Illuminate\Database\ConnectionInterface
     */
    public static function DB(): ConnectionInterface
    {
        return DB::connection();
    }
}
