<?php declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Tool
{
    /**
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($this->enabled($request) === false) {
            return response('Unauthorized.', 401);
        }

        return $next($request);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return bool
     */
    protected function enabled(Request $request): bool
    {
        return config('tool.enabled')
            && in_array($request->ip(), explode(',', config('tool.ip')));
    }
}
