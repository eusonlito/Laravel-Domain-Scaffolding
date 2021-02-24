<?php declare(strict_types=1);

namespace App\Providers;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;
use App\Domains\Configuration\Model\Configuration;

class App extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        $this->locale();
    }

    /**
     * @return void
     */
    protected function locale(): void
    {
        $locale = config('app.locale_system')[config('app.locale')];

        setlocale(LC_COLLATE, $locale);
        setlocale(LC_CTYPE, $locale);
        setlocale(LC_MESSAGES, $locale);
        setlocale(LC_MONETARY, $locale);
        setlocale(LC_TIME, $locale);
    }

    /**
     * @return void
     */
    public function register(): void
    {
        $this->singletons();
        $this->paginator();
    }

    /**
     * @return void
     */
    protected function singletons(): void
    {
        $this->app->singleton('user', static fn (): ?Authenticatable => auth()->user());
        $this->app->singleton('configuration', static fn () => Configuration::pluck('value', 'key'));
        $this->app->singleton('language', static fn () => null);
    }

    /**
     * @return void
     */
    protected function paginator(): void
    {
        Paginator::useBootstrap();
    }
}
