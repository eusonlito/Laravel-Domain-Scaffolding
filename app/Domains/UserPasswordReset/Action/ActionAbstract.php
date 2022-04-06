<?php declare(strict_types=1);

namespace App\Domains\UserPasswordReset\Action;

use App\Domains\SharedApp\Action\ActionAbstract as ActionAbstractShared;
use App\Domains\UserPasswordReset\Model\UserPasswordReset as Model;

abstract class ActionAbstract extends ActionAbstractShared
{
    /**
     * @var ?\App\Domains\UserPasswordReset\Model\UserPasswordReset
     */
    protected ?Model $row;
}
