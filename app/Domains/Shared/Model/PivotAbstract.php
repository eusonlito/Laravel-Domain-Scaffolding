<?php declare(strict_types=1);

namespace App\Domains\Shared\Model;

use DateTime;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Support\Facades\DB;
use Eusonlito\DatabaseCache\CacheBuilderTrait;
use App\Domains\Shared\Model\Traits\DateDisabled;
use App\Domains\Shared\Model\Traits\MutatorDisabled;

abstract class PivotAbstract extends Pivot
{
    use DateDisabled, MutatorDisabled, CacheBuilderTrait;

    /**
     * @var bool
     */
    public static $snakeAttributes = false;

    /**
     * @var bool
     */
    public $incrementing = true;

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
