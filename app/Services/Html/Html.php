<?php declare(strict_types=1);

namespace App\Services\Html;

use Carbon\Carbon;
use App\Services\Image\Transform;

class Html
{
    /**
     * @var array
     */
    protected static array $svg = [];

    /**
     * @var string
     */
    protected static string $timezone;

    /**
     * @var string
     */
    protected static string $cache;

    /**
     * @param string $image
     * @param string $transform = ''
     *
     * @return string
     */
    public static function image(string $image, string $transform = ''): string
    {
        return Transform::image($image, $transform);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function asset(string $path): string
    {
        if (empty(static::$cache ??= config('cache.version'))) {
            return asset('assets/'.$path);
        }

        return asset('assets/'.static::$cache.'/'.$path);
    }

    /**
     * @param string $path
     *
     * @return string
     */
    public static function svg(string $path): string
    {
        return static::$svg[$path] ??= file_get_contents(resource_path($path.'.svg'));
    }

    /**
     * @param int $value
     *
     * @return string
     */
    public static function money(int $value): string
    {
        return number_format($value, 2, ',', '.').'€';
    }

    /**
     * @param string $datetime
     * @param string $format = '%e/%B/%Y'
     *
     * @return string
     */
    public static function dateFromDate(string $datetime, string $format = '%e-%b-%Y'): string
    {
        return strftime($format, strtotime($datetime));
    }

    /**
     * @param int $time
     * @param string $format = '%e/%B/%Y'
     *
     * @return string
     */
    public static function dateFromTime(int $time, string $format = '%e-%b-%Y'): string
    {
        return strftime($format, $time);
    }

    /**
     * @param string $date
     * @param string $format = '%e-%b-%Y %H:%M'
     *
     * @return string
     */
    public static function dateRelativeFromDate(string $date, string $format = '%e-%b-%Y %H:%M'): string
    {
        return static::dateRelativeFromTime(strtotime($date), $format);
    }

    /**
     * @param int $time
     * @param string $format = '%e-%b-%Y %H:%M'
     *
     * @return string
     */
    public static function dateRelativeFromTime(int $time, string $format = '%e-%b-%Y %H:%M'): string
    {
        $diff = time() - $time;

        if ($diff > 172800) {
            return static::dateFromTime($time, $format);
        }

        if ($diff > 86400) {
            return __('common.date.yesterday').' '.date('H:i', $time);
        }

        return static::dateHumanFromTime($time);
    }

    /**
     * @param string $date
     *
     * @return string
     */
    public static function dateHumanFromDate(string $date): string
    {
        return static::dateHumanFromTime(strtotime($date));
    }

    /**
     * @param int $time
     *
     * @return string
     */
    public static function dateHumanFromTime(int $time): string
    {
        return Carbon::createFromTimestamp($time, static::$timezone ??= config('app.timezone'))->diffForHumans();
    }
}
