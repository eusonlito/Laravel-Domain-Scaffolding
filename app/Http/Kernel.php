<?php declare(strict_types=1);

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as KernelVendor;
use App\Domains\Configuration\Middleware\Request as ConfigurationRequest;
use App\Domains\Language\Middleware\Request as LanguageRequest;
use App\Domains\User\Middleware\Auth as UserAuth;
use App\Domains\User\Middleware\AuthRedirect as UserAuthRedirect;
use App\Domains\User\Middleware\Confirmed as UserConfirmed;
use App\Domains\User\Middleware\Enabled as UserEnabled;
use App\Http\Middleware\MessagesShareFromSession;
use App\Http\Middleware\RequestLogger;
use App\Http\Middleware\Reset;

class Kernel extends KernelVendor
{
    /**
     * @var array
     */
    protected $middleware = [
        \Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode::class,
        \Illuminate\Cookie\Middleware\EncryptCookies::class,
        \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
        \Illuminate\Session\Middleware\StartSession::class,
        \Illuminate\Foundation\Http\Middleware\TrimStrings::class,
        RequestLogger::class,
        Reset::class,
        MessagesShareFromSession::class,
        ConfigurationRequest::class,
        LanguageRequest::class,
    ];

    /**
     * @var array
     */
    protected $routeMiddleware = [
        'user.auth' => UserAuth::class,
        'user.auth.redirect' => UserAuthRedirect::class,
        'user.confirmed' => UserConfirmed::class,
        'user.enabled' => UserEnabled::class,
    ];
}
