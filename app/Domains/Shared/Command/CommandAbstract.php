<?php declare(strict_types=1);

namespace App\Domains\Shared\Command;

use Illuminate\Console\Command;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Domains\Shared\Traits\Factory;
use App\Exceptions\ValidatorException;

abstract class CommandAbstract extends Command
{
    use Factory;

    /**
     * @return self
     */
    final public function __construct()
    {
        $this->request = request();

        parent::__construct();
    }

    /**
     * @param mixed $string
     * @param int|string|null $verbosity = false
     *
     * @return void
     */
    final public function info($string, $verbosity = false)
    {
        if (is_string($string) === false) {
            $string = print_r($string, true);
        }

        parent::info('['.date('Y-m-d H:i:s').'] '.$string, $verbosity);
    }

    /**
     * @param mixed $string
     * @param int|string|null $verbosity = false
     *
     * @return void
     */
    final public function error($string, $verbosity = false)
    {
        if (is_string($string) === false) {
            $string = print_r($string, true);
        }

        parent::error('['.date('Y-m-d H:i:s').'] '.$string, $verbosity);
    }

    /**
     * @param array $keys
     *
     * @return void
     */
    final protected function checkOptions(array $keys): void
    {
        foreach ($keys as $key) {
            if ($this->option($key) === null) {
                throw new ValidatorException(sprintf('Option "%s" is required', $key));
            }
        }
    }

    /**
     * @return \Illuminate\Http\Request
     */
    final protected function requestWithOptions(): Request
    {
        return request()->replace($this->arguments() + $this->options());
    }

    /**
     * @param null|int|\Illuminate\Contracts\Auth\Authenticatable $user = null
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    final protected function actingAs($user = null): Authenticatable
    {
        $model = config('auth.providers.users.model');

        if (is_null($user)) {
            $user = new $model;
        } elseif (is_int($user)) {
            $user = $model::findOrFail($user);
        }

        Auth::login($user);

        return $this->auth = $user;
    }
}
