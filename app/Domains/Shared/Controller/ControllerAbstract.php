<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Domains\Shared\Action\ActionFactoryAbstract;
use App\Domains\Shared\Model\ModelAbstract;
use App\Domains\Shared\Traits\Factory;

abstract class ControllerAbstract extends Controller
{
    use Factory;

    /**
     * @return self
     */
    final public function __construct()
    {
        $this->middleware(fn ($request, $next) => $this->setup($request, $next));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Clousure $next
     *
     * @return mixed
     */
    final protected function setup(Request $request, Closure $next)
    {
        $this->request = $request;
        $this->auth = $request->user();

        $this->init();

        return $next($request);
    }

    /**
     * @return void
     */
    protected function init(): void
    {
    }

    /**
     * @param mixed $data
     * @param int $status = 200
     *
     * @return \Illuminate\Http\JsonResponse
     */
    final protected function json($data, int $status = 200): JsonResponse
    {
        return response()->json($data, $status);
    }

    /**
     * @param ?\App\Domains\Shared\Model\ModelAbstract $row = null
     *
     * @return \App\Domains\Shared\Action\ActionFactoryAbstract
     */
    final protected function action(?ModelAbstract $row = null): ActionFactoryAbstract
    {
        return $this->factory(null, $row)->action();
    }
}
