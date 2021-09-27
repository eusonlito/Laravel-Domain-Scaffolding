<?php declare(strict_types=1);

namespace App\Services\Html;

use App\Services\Image\Transform;
use App\Services\Html\Traits as HtmlTrait;

class Html
{
    use HtmlTrait;

    /**
     * @var array
     */
    protected static array $asset = [];

    /**
     * @var array
     */
    protected static array $query;

    /**
     * @param string $path
     *
     * @return string
     */
    public static function asset(string $path): string
    {
        if (isset(static::$asset[$path])) {
            return static::$asset[$path];
        }

        if (is_file($file = public_path($path))) {
            $path .= '?'.filemtime($file);
        }

        return static::$asset[$path] = asset($path);
    }

    /**
     * @param string $path
     * @param string $transform = ''
     *
     * @return string
     */
    public static function image(string $path, string $transform = ''): string
    {
        return Transform::image($path, $transform);
    }

    /**
     * @param array $query
     *
     * @return string
     */
    public static function query(array $query): string
    {
        return helper()->query($query);
    }

    /**
     * @param float $value
     * @param ?int $decimals = null
     *
     * @return string
     */
    public static function number(float $value, ?int $decimals = null): string
    {
        return helper()->number($value, $decimals);
    }

    /**
     * @param float $value
     * @param ?int $decimals = null
     *
     * @return string
     */
    public static function money(float $value, ?int $decimals = null): string
    {
        return helper()->money($value, $decimals);
    }
}
