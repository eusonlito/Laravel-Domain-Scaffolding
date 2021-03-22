<?php declare(strict_types=1);

namespace App\Services\Helper;

use App\Exceptions\NotFoundException;

class Helper
{
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
     * @param array $query
     *
     * @return string
     */
    public function query(array $query): string
    {
        static $request = null;

        return http_build_query($query + ($request ??= request()->query()));
    }

    /**
     * @param float $value
     * @param int $decimals = 4
     *
     * @return string
     */
    public function number(float $value, int $decimals = 4): string
    {
        return number_format($value, $decimals, ',', '.');
    }

    /**
     * @param float $value
     * @param int $decimals = 4
     *
     * @return string
     */
    public function money(float $value, int $decimals = 4): string
    {
        return $this->number($value, $decimals).'€';
    }

    /**
     * @param float $first
     * @param float $second
     *
     * @return string
     */
    public function percent(float $first, float $second): string
    {
        return ($first ? static::number(100 - ($second * 100 / $first), 2) : '-').'%';
    }

    /**
     * @param string $message = ''
     *
     * @throws \App\Exceptions\NotFoundException
     *
     * @return void
     */
    public function notFound(string $message = ''): void
    {
        throw new NotFoundException($message ?: __('common.error.not-found'));
    }
}
