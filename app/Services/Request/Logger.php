<?php declare(strict_types=1);

namespace App\Services\Request;

use Throwable;
use Illuminate\Http\Request as RequestVendor;
use App\Services\Logger\RotatingFileAbstract;

class Logger extends RotatingFileAbstract
{
    /**
     * @var string
     */
    protected static string $name = 'requests';

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public static function fromRequest(RequestVendor $request): void
    {
        static::info($request->url(), [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'headers' => static::headers($request),
            'input' => static::input($request),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \Throwable $e
     *
     * @return void
     */
    public static function fromException(RequestVendor $request, Throwable $e): void
    {
        static::error($request->url(), [
            'ip' => $request->ip(),
            'method' => $request->method(),
            'headers' => static::headers($request),
            'input' => static::input($request),
            'class' => get_class($e),
            'code' => (method_exists($e, 'getStatusCode') ? $e->getStatusCode() : $e->getCode()),
            'status' => (method_exists($e, 'getStatus') ? $e->getStatus() : null),
            'message' => $e->getMessage(),
        ]);
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected static function headers(RequestVendor $request): array
    {
        $data = $request->headers->all();

        unset($data['authorization'], $data['cookie'], $data['php-auth-user'], $data['php-auth-pw']);

        return $data;
    }

    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    protected static function input(RequestVendor $request): array
    {
        return $request->except('password');
    }
}
