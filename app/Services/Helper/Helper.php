<?php declare(strict_types=1);

namespace App\Services\Helper;

use Error;
use ErrorException;
use LogicException;
use RecursiveArrayIterator;
use RecursiveIteratorIterator;
use RuntimeException;
use Stringable;
use Throwable;
use Symfony\Component\Debug\Exception\FatalThrowableError;
use App\Exceptions\NotFoundException;
use App\Services\Helper\Traits\Helper as HelperTrait;

class Helper
{
    use HelperTrait;

    /**
     * @return string
     */
    public function uuid(): string
    {
        $data = random_bytes(16);

        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);

        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }

    /**
     * @param int $length
     * @param bool $safe = false
     * @param bool $lower = false
     *
     * @return string
     */
    public function uniqidReal(int $length, bool $safe = false, bool $lower = false): string
    {
        if ($safe) {
            $string = '23456789bcdfghjkmnpqrstwxyzBCDFGHJKMNPQRSTWXYZ';
        } else {
            $string = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        }

        if ($lower) {
            $string = strtolower($string);
        }

        return substr(str_shuffle(str_repeat($string, rand((int)($length / 2), $length))), 0, $length);
    }

    /**
     * @param string $string
     * @param int $prefix = 0
     * @param int $suffix = 0
     *
     * @return string
     */
    public function slug(string $string, int $prefix = 0, int $suffix = 0): string
    {
        if ($prefix) {
            $string = $this->uniqidReal($prefix, true).'-'.$string;
        }

        if ($suffix) {
            $string .= '-'.$this->uniqidReal($suffix, true);
        }

        return str_slug($string);
    }

    /**
     * @param mixed $value
     *
     * @return ?string
     */
    public function jsonEncode($value): ?string
    {
        if ($value === null) {
            return null;
        }

        return json_encode($value, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR);
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysWhitelist(array $array, array $keys): array
    {
        return array_intersect_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $keys
     *
     * @return array
     */
    public function arrayKeysBlacklist(array $array, array $keys): array
    {
        return array_diff_key($array, array_flip($keys));
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesWhitelist(array $array, array $values): array
    {
        return array_intersect($array, $values);
    }

    /**
     * @param array $array
     * @param array $values
     *
     * @return array
     */
    public function arrayValuesBlacklist(array $array, array $values): array
    {
        return array_diff($array, $values);
    }

    /**
     * @param array $array
     * @param ?callable $callback = null
     *
     * @return array
     */
    public function arrayFilterRecursive(array $array, ?callable $callback = null): array
    {
        $callback ??= static fn ($value) => (bool)$value;

        return array_filter(array_map(fn ($value) => is_array($value) ? $this->arrayFilterRecursive($value, $callback) : $value, $array), $callback);
    }

    /**
     * @param array $array
     * @param callable $callback
     * @param bool $values_only = true
     *
     * @return array
     */
    public function arrayMapRecursive(array $array, callable $callback, bool $values_only = true): array
    {
        $keys = array_keys($array);

        $map = function ($value, $key) use ($callback, $values_only) {
            if (is_array($value) === false) {
                return $callback($value, $key);
            }

            if ($values_only) {
                return $this->arrayMapRecursive($value, $callback, $values_only);
            }

            return $this->arrayMapRecursive($callback($value, $key), $callback, $values_only);
        };

        return array_combine($keys, array_map($map, $array, $keys));
    }

    /**
     * @param array $array
     *
     * @return array
     */
    public function arrayFlatten(array $array): array
    {
        return iterator_to_array(new RecursiveIteratorIterator(new RecursiveArrayIterator($array)), true);
    }

    /**
     * @param array $array
     * @param array $exclude = []
     * @param array $include = []
     *
     * @return array
     */
    public function arrayValuesRecursive(array $array, array $exclude = [], array $include = []): array
    {
        $result = [];

        foreach ($array as $key => $value) {
            if ($exclude && in_array($key, $exclude)) {
                continue;
            }

            if (is_array($value)) {
                $result = array_merge($result, $this->arrayValuesRecursive($value, $exclude, $include));
            } elseif (empty($include) || in_array($key, $include)) {
                $result[] = $value;
            }
        }

        return $result;
    }

    /**
     * @param array $array
     *
     * @return string
     */
    public function arrayHtmlAttributes(array $array): string
    {
        return implode(' ', array_filter(array_map(function ($key, $value) {
            if (is_bool($value)) {
                return $key;
            }

            if (is_string($value) || ($value instanceof Stringable)) {
                return $key.'='.htmlentities((string)$value);
            }

            return '';
        }, array_keys($array), $array)));
    }

    /**
     * @param array $query
     * @param string $url = ''
     *
     * @return string
     */
    public function query(array $query, string $url = ''): string
    {
        $query = http_build_query($query);

        if (empty($query)) {
            return $url;
        }

        if (empty($url)) {
            return $query;
        }

        return $url.(str_contains($url, '?') ? '&' : '?').$query;
    }

    /**
     * @param ?float $value
     * @param int $decimals = 2
     * @param ?string $default = '-'
     *
     * @return ?string
     */
    public function number(?float $value, int $decimals = 2, ?string $default = '-'): ?string
    {
        if ($value === null) {
            return $default;
        }

        return number_format($value, $decimals, ',', '.');
    }

    /**
     * @param ?float $value
     * @param int $decimals = 2
     *
     * @return ?string
     */
    public function money(?float $value, int $decimals = 2): ?string
    {
        return $this->number($value, $decimals).'€';
    }

    /**
     * @param ?string $date
     * @param ?string $default = '-'
     *
     * @return string
     */
    public function dateLocal(?string $date, ?string $default = '-'): ?string
    {
        if (empty($date)) {
            return $default;
        }

        $time = strtotime($date);

        if ($time === false) {
            return $default;
        }

        return date(str_contains($date, ' ') ? 'd/m/Y H:i' : 'd/m/Y', $time);
    }

    /**
     * @param string $date
     * @param ?string $default = null
     *
     * @return ?string
     */
    public function dateToDate(string $date, ?string $default = null): ?string
    {
        if (empty($date)) {
            return $default;
        }

        [$day, $time] = explode(' ', $date) + ['', ''];

        if (str_contains($day, ':')) {
            [$day, $time] = [$time, $day];
        }

        if (!preg_match('#^[0-9]{1,4}[/\-][0-9]{1,2}[/\-][0-9]{1,4}$#', $day)) {
            return $default;
        }

        if ($time) {
            if (substr_count($time, ':') === 1) {
                $time .= ':00';
            }

            if (!preg_match('#^[0-9]{1,2}:[0-9]{1,2}:[0-9]{1,2}$#', $time)) {
                return $default;
            }
        }

        $day = preg_split('#[/\-]#', $day);

        if (strlen($day[0]) !== 4) {
            $day = array_reverse($day);
        }

        return trim(implode('-', $day).' '.$time);
    }

    /**
     * @param string $message = ''
     * @param string $code = ''
     *
     * @throws \App\Exceptions\NotFoundException
     *
     * @return void
     */
    public function notFound(string $message = '', string $code = ''): void
    {
        throw new NotFoundException($message ?: __('common.error.not-found'), null, null, $code);
    }

    /**
     * @param \Throwable $e
     *
     * @return bool
     */
    public function isExceptionSystem(Throwable $e): bool
    {
        return ($e instanceof Error)
            || ($e instanceof ErrorException)
            || ($e instanceof LogicException)
            || ($e instanceof FatalThrowableError)
            || ($e instanceof RuntimeException);
    }

    /**
     * @return bool
     */
    public function browserIsMobile(): bool
    {
        return empty($agent = request()->server('HTTP_USER_AGENT'))
            || preg_match('/(Mobile|Android|Tablet|iPhone|Mobi\/)/uis', strtolower($agent));
    }

    /**
     * @return bool
     */
    public function userIsBot(): bool
    {
        $agent = request()->server('HTTP_USER_AGENT');

        return empty($agent)
            || preg_match('/[a-z0-9\-_]*(bot|crawl|archiver|transcoder|spider|uptime|validator|fetcher|cron|checker|reader|extractor|monitoring|analyzer|scraper)/', strtolower($agent));
    }
}
