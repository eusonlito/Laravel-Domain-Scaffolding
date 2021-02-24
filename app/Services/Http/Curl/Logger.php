<?php declare(strict_types=1);

namespace App\Services\Http\Curl;

use App\Services\Logger\RotatingFileAbstract;

class Logger extends RotatingFileAbstract
{
    /**
     * @var string
     */
    protected static string $name = 'curl';
}
