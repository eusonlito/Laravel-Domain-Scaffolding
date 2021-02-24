<?php declare(strict_types=1);

namespace App\Services\Request;

use Illuminate\Http\Request;
use App\Domains\Language\Model\Language as Model;

class Language
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public static function load(Request $request): void
    {
        static::set(static::byHeader((string)$request->header('Accept-Language')));
    }

    /**
     * @param string $header
     *
     * @return \App\Domains\Language\Model\Language
     */
    protected static function byHeader(string $header): Model
    {
        $iso = preg_split('/[^a-zA-Z]/', $header)[0];

        return cache()
            ->tags('language')
            ->remember('language|'.$iso, 3600, static fn () => static::byHeaderCached($iso));
    }

    /**
     * @param string $iso
     *
     * @return \App\Domains\Language\Model\Language
     */
    protected static function byHeaderCached(string $iso): Model
    {
        if ($iso && ($exists = Model::enabled()->where('iso', $iso)->first())) {
            return $exists;
        }

        return Model::enabled()->where('default', 1)->first();
    }

    /**
     * @param \App\Domains\Language\Model\Language $language
     *
     * @return void
     */
    protected static function set(Model $language): void
    {
        app()->setLocale($language->iso);
        app()->singleton('language', static fn () => $language);
    }
}
