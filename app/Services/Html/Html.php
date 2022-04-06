<?php declare(strict_types=1);

namespace App\Services\Html;

use App\Services\Image\Transform;

class Html
{
    /**
     * @param ?string $path
     *
     * @return string
     */
    public static function asset(?string $path): string
    {
        static $asset = [];

        if (empty($path)) {
            return '';
        }

        if (str_starts_with($path, 'data:')) {
            return $path;
        }

        if (isset($asset[$path])) {
            return $asset[$path];
        }

        if (is_file($file = public_path($path))) {
            $path .= '?v'.filemtime($file);
        }

        return $asset[$path] = asset($path);
    }

    /**
     * @param ?string $path
     * @param bool $cache = true
     *
     * @return string
     */
    public static function inline(?string $path, bool $cache = true): string
    {
        static $inline = [];

        if (empty($path)) {
            return '';
        }

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
     * @param string $path
     * @param string $class = ''
     *
     * @return string
     */
    public static function svg(string $path, string $class = ''): string
    {
        return str_replace('class=""', 'class="'.$class.'"', static::inline($path));
    }

    /**
     * @param ?string $path
     * @param string $transform = ''
     *
     * @return string
     */
    public static function image(?string $path, string $transform = ''): string
    {
        if (empty($path)) {
            return '';
        }

        if (empty($transform) || str_starts_with($path, 'data:')) {
            return $path;
        }

        return route('storage.transform', [str_replace([',', '|'], ['_', '-'], $transform), ltrim($path, '/')]);
    }

    /**
     * @param array $query
     * @param string $url = ''
     *
     * @return string
     */
    public static function query(array $query, string $url = ''): string
    {
        return helper()->query($query, $url);
    }

    /**
     * @param ?float $value
     * @param ?int $decimals = null
     *
     * @return string
     */
    public static function number(?float $value, ?int $decimals = null): string
    {
        return helper()->number($value, $decimals);
    }

    /**
     * @param ?float $value
     * @param int $decimals = 2
     *
     * @return ?string
     */
    public static function money(?float $value, int $decimals = 2): ?string
    {
        return helper()->money($value, $decimals);
    }

    /**
     * @param string $text
     * @param int $limit = 140
     * @param string $end = '...'
     *
     * @return string
     */
    public static function cut(string $text, int $limit = 140, string $end = '...'): string
    {
        if (strlen($text) <= (int)$limit) {
            return $text;
        }

        $length = strlen($text);
        $num = 0;
        $tag = 0;

        for ($n = 0; $n < $length; $n++) {
            if ($text[$n] === '<') {
                $tag++;
                continue;
            }

            if ($text[$n] === '>') {
                $tag--;
                continue;
            }

            if ($tag !== 0) {
                continue;
            }

            $num++;

            if ($num < $limit) {
                continue;
            }

            $text = substr($text, 0, $n);

            if ($space = strrpos($text, ' ')) {
                $text = substr($text, 0, $space);
            }

            break;
        }

        if (strlen($text) === $length) {
            return $text;
        }

        $text .= $end;

        if (!preg_match_all('|(<([\w]+)[^>]*>)|', $text, $aBuffer) || empty($aBuffer[1])) {
            return $text;
        }

        preg_match_all('|</([a-zA-Z]+)>|', $text, $aBuffer2);

        if (count($aBuffer[2]) === count($aBuffer2[1])) {
            return $text;
        }

        foreach ($aBuffer[2] as $k => $tag) {
            if (empty($aBuffer2[1][$k]) || ($tag !== $aBuffer2[1][$k])) {
                $text .= '</'.$tag.'>';
            }
        }

        return $text;
    }
}
