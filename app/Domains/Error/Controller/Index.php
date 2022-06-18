<?php declare(strict_types=1);

namespace App\Domains\Error\Controller;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Index extends ControllerAbstract
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return self
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->auth = $request->user();

        $this->init();
    }

    /**
     * @param \Throwable $e
     *
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Throwable $e): Response
    {
        $this->meta('title', $e->getMessage());

        return $this->page('error.index', $this->data($e), $e->getCode());
    }

    /**
     * @param \Throwable $e
     *
     * @return array
     */
    protected function data(Throwable $e): array
    {
        return [
            'code' => $e->getCode(),
            'message' => $e->getMessage(),
        ];
    }
}
