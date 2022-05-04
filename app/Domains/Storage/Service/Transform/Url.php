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
        $path = static::path($path);

        return route('storage.transform', [
            static::hash($path, $transform),
            static::time($path),
            static::transform($transform),
            $path,
        ]);
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
     * @param string $path
     *
     * @return string
     */
    public static function time(string $path): string
    {
        if (is_file($file = public_path($path))) {
            return substr((string)filemtime($file), -4);
        }

        return '0';
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
