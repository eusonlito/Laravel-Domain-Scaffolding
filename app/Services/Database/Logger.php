<?php declare(strict_types=1);

namespace App\Services\Database;

use DateTime;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class Logger
{
    /**
     * @var string
     */
    protected static string $file = '';

    /**
     * @return void
     */
    public static function listen(): void
    {
        if (static::$file) {
            return;
        }

        static::load();
        static::write('['.date('Y-m-d H:i:s').'] ['.Request::method().'] '.Request::fullUrl());

        DB::listen(static function ($sql) {
            foreach ($sql->bindings as $i => $binding) {
                if ($binding instanceof DateTime) {
                    $sql->bindings[$i] = $binding->format('Y-m-d H:i:s');
                } elseif (is_string($binding)) {
                    $sql->bindings[$i] = "'${binding}'";
                } elseif (is_bool($binding)) {
                    $sql->bindings[$i] = $binding ? 'true' : 'false';
                }
            }

            static::write(vsprintf(str_replace(['%', '?'], ['%%', '%s'], $sql->sql), $sql->bindings));
        });
    }

    /**
     * @return void
     */
    protected static function load(): void
    {
        static::file();

        if (is_dir($dir = dirname(static::$file)) === false) {
            mkdir($dir, 0755, true);
        }
    }

    /**
     * @return void
     */
    protected static function file(): void
    {
        $file = array_filter(explode('-', preg_replace('/[^a-z0-9]+/i', '-', Request::path())));
        $file = implode('-', array_map(static fn ($value) => substr($value, 0, 20), $file)) ?: '-';

        static::$file = storage_path('logs/query/'.date('Y-m-d').'/'.substr($file, 0, 150).'.log');
    }

    /**
     * @param string $message
     *
     * @return void
     */
    protected static function write(string $message): void
    {
        file_put_contents(static::$file, "\n\n".$message, FILE_APPEND | LOCK_EX);
    }
}
