<?php declare(strict_types=1);

namespace App\Domains\Shared\Command;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
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
            if (strlen((string)$this->option($key)) === 0) {
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
}
