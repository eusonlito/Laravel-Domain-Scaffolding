<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Services\Request\Logger;

class RequestLogger
{
    /**
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (config('logging.channels.request.enabled')) {
            Logger::fromRequest($request);
        }

        return $next($request);
    }
}
