<?php declare(strict_types=1);

namespace App\Domains\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class Confirmed
{
    /**
     * @param \Illuminate\Http\Request  $request
     * @param \Closure  $next
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (empty($request->user()->confirmed_at)) {
            return redirect()->route('user.confirm.start');
        }

        return $next($request);
    }
}
