<?php declare(strict_types=1);

namespace App\Domains\Shared\Model;

use DateTime;
use Illuminate\Database\Eloquent\Model;
use App\Domains\Shared\Model\Traits\DateDisabled;
use App\Domains\Shared\Model\Traits\MutatorDisabled;

abstract class ModelAbstract extends Model
{
    use DateDisabled, MutatorDisabled;

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
     * @param string $key
     *
     * @return \DateTime
     */
    public function datetime(string $key): DateTime
    {
        return new DateTime($this->$key);
    }
}
