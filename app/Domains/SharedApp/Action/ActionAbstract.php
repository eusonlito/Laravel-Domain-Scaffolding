<?php declare(strict_types=1);

namespace App\Domains\SharedApp\Action;

use App\Domains\Shared\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\SharedApp\Action\Traits\Cache as CacheTrait;

abstract class ActionAbstract extends ActionAbstractShared
{
    use CacheTrait;
}
