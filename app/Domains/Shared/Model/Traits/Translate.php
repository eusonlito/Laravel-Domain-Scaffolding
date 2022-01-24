<?php declare(strict_types=1);

namespace App\Domains\Shared\Model\Traits;

trait Translate
{
    /**
     * @param string $column
     * @param ?string $locale = null
     * @param string|array|null $default = null
     *
     * @return string|array
     */
    public function translate(string $column, ?string $locale = null, string|array|null $default = null): string|array
    {
        static $language;

        if (empty($value = $this->attributes[$column])) {
            return $default;
        }

        if (is_string($value)) {
            $value = json_decode($value, true);
        }

        if (is_array($value) === false) {
            return (string)$value;
        }

        if ($language === null) {
            $language = app('language');
        }

        return $value[$locale ?: $language->locale] ?? $default;
    }
}
