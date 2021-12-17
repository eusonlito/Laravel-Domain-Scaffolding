<?php declare(strict_types=1);

namespace App\Services\Html;

use App\Services\Image\Transform;

class Html
{
    /**
     * @param string $path
     *
     * @return string
     */
    public static function asset(string $path): string
    {
        static $asset = [];

        if (isset($asset[$path])) {
            return $asset[$path];
        }

        if (is_file($file = public_path($path))) {
            $path .= '?v'.filemtime($file);
        }

        return $asset[$path] = asset($path);
    }

    /**
     * @param string $path
     * @param bool $cache = true
     *
     * @return string
     */
    public static function inline(string $path, bool $cache = true): string
    {
        static $inline = [];

        if ($cache && isset($inline[$path])) {
            return $inline[$path];
        }

        if (is_file($file = public_path($path))) {
            $contents = file_get_contents($file);
        } else {
            $contents = '';
        }

        return $cache ? ($inline[$path] = $contents) : $contents;
    }

    /**
     * @param string $name
     * @param string $class = ''
     *
     * @return string
     */
    public static function icon(string $name, string $class = ''): string
    {
        return '<svg class="feather '.$class.'"><use xlink:href="'.static::asset('build/images/feather-sprite.svg').'#'.$name.'" /></svg>';
    }

    /**
     * @param string $path
     * @param string $class = ''
     *
     * @return string
     */
    public static function svg(string $path, string $class = ''): string
    {
        return str_replace('class=""', 'class="'.$class.'"', static::inline('build/images/svg/'.$path.'.svg'));
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

    /**
     * @param bool $status
     *
     * @return string
     */
    public static function status(bool $status): string
    {
        if ($status) {
            $color = 'svg-icon-success';
            $icon = 'check-square';
        } else {
            $color = 'svg-icon-danger';
            $icon = 'square';
        }

        return '<span class="svg-icon svg-icon-2 stroke-white '.$color.'">'.static::icon($icon, 'w-4 h-4 mr-2').'</span>';
    }
}
