<?php declare(strict_types=1);

namespace App\Domains\Text\Model;

use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\Shared\Model\Traits\Translate as TranslateTrait;
use App\Domains\Text\Model\Builder\Text as Builder;

class Text extends ModelAbstract
{
    use TranslateTrait;

    /**
     * @var string
     */
    protected $table = 'text';

    /**
     * @var string
     */
    public static string $foreign = 'text_id';

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
     * @return string
     */
    public function template(): string
    {
        return $this->attributes['template'].'-'.app('language')->iso;
    }
}
