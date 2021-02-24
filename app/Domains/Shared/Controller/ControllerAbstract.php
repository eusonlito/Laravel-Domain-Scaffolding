<?php declare(strict_types=1);

namespace App\Domains\Shared\Controller;

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
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    final public function __construct(Request $request)
    {
        $this->request = $request;
        $this->init();
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
