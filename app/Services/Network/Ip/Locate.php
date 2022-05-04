<?php declare(strict_types=1);

namespace App\Services\Network\Ip;

use Exception;
use stdClass;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class Locate
{
    /**
     * @const int
     */
    protected const CACHE_TTL = 60 * 60 * 24 * 30;

    /**
     * @const int
     */
    protected const CACHE_TTL_FAIL = 60 * 10;

    /**
     * @param string $ip
     *
     * @return ?\stdClass
     */
    public static function locate(string $ip): ?stdClass
    {
        return static::locateCached($ip)
            ?: static::locateFail($ip);
    }

    /**
     * @param string $ip
     *
     * @return \stdClass|bool|null
     */
    protected static function locateCached(string $ip): stdClass|bool|null
    {
        return Cache::remember('ip-'.$ip, static::CACHE_TTL, static fn () => static::locateByIp($ip));
    }

    /**
     * @param string $ip
     *
     * @return void
     */
    protected static function locateFail(string $ip): void
    {
        Cache::remember('ip-'.$ip, static::CACHE_TTL_FAIL, static fn () => false);
    }

    /**
     * @param string $ip
     *
     * @return ?\stdClass
     */
    protected static function locateByIp(string $ip): ?stdClass
    {
        if (in_array($ip, ['127.0.0.1', '::1'])) {
            return null;
        }

        foreach (config('ip.services', []) as $service) {
            if ($response = static::service($service, $ip)) {
                return $response;
            }
        }

        return null;
    }

    /**
     * @param string $service
     * @param string $ip
     *
     * @return ?\stdClass
     */
    protected static function service(string $service, string $ip): ?stdClass
    {
        try {
            return (new $service())->locate($ip);
        } catch (Exception $e) {
            Log::error($e);
        }

        return null;
    }
}
