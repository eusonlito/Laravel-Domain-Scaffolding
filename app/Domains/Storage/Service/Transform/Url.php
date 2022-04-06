<?php declare(strict_types=1);

namespace App\Domains\Storage\Service\Transform;

class Url
{
    /**
     * @param string $path
     * @param string $transform
     *
     * @return string
     */
    public static function get(string $path, string $transform): string
    {
        return route('storage.transform', [static::hash($path, $transform), static::transform($transform), static::path($path)]);
    }

    /**
     * @param string $path
     * @param string $transform
     *
     * @return string
     */
    public static function hash(string $path, string $transform): string
    {
        return substr(md5($path.$transform), 4, 3);
    }

    /**
     * @param string $transform
     *
     * @return string
     */
    public static function transform(string $transform): string
    {
        return str_replace([',', '|'], ['_', '-'], $transform);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function path(string $path): string
    {
        return ltrim($path, '/');
    }
}
