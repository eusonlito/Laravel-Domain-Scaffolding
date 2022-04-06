<?php declare(strict_types=1);

namespace App\Domains\Storage\Service\Transform;

use App\Services\Logger\RotatingFileAbstract;

class Logger extends RotatingFileAbstract
{
    /**
     * @var string
     */
    protected static string $name = 'storage-transform';
}
