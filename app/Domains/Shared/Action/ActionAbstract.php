<?php declare(strict_types=1);

namespace App\Domains\Shared\Action;

use Throwable;
use Closure;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Domains\Shared\Model\ModelAbstract;
use Illuminate\Http\Request;
use App\Domains\Shared\Traits\Factory;

abstract class ActionAbstract
{
    use Factory;

    /**
     * @param ?\Illuminate\Http\Request $request = null
     * @param ?\Illuminate\Contracts\Auth\Authenticatable $auth = null
     * @param ?\App\Domains\Shared\Model\ModelAbstract $row = null
     * @param array $data = []
     *
     * @return self
     */
    final public function __construct(?Request $request = null, ?Authenticatable $auth = null, ?ModelAbstract $row = null, array $data = [])
    {
        $this->request = $request;
        $this->auth = $auth;
        $this->row = $row;
        $this->data = $data;
    }

    /**
     * @param \Closure $closure
     * @param ?\Closure $rollback = null
     *
     * @return mixed
     */
    final protected function transaction(Closure $closure, ?Closure $rollback = null)
    {
        try {
            return $this->connection()->transaction($closure);
        } catch (Throwable $e) {
            if ($rollback) {
                return $rollback($e);
            }

            throw $e;
        }
    }
}
