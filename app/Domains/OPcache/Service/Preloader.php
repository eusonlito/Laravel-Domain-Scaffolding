<?php declare(strict_types=1);

namespace App\Domains\OPcache\Service;

class Preloader
{
    /**
     * @var int
     */
    private static int $count = 0;

    /**
     * @var array
     */
    private array $ignores = [];

    /**
     * @var array
     */
    private array $paths;

    /**
     * @var array
     */
    private array $fileMap;

    /**
     * @var array
     */
    private array $classMap;

    /**
     * @var array
     */
    private array $log = [];

    /**
     * @param string $base
     *
     * @return self
     */
    public function __construct(string $base)
    {
        $this->classMap = require $base.'/vendor/composer/autoload_classmap.php';
        $this->fileMap = array_flip($this->classMap);
    }

    /**
     * @param string ...$paths
     *
     * @return self
     */
    public function paths(string ...$paths): self
    {
        $this->paths = $paths;

        return $this;
    }

    /**
     * @param string ...$names
     *
     * @return self
     */
    public function ignore(string ...$names): self
    {
        $this->ignores = array_merge($this->ignores, $names);

        return $this;
    }

    /**
     * @return self
     */
    public function load(): self
    {
        static::$count = 0;

        $time = microtime(true);

        foreach ($this->paths as $path) {
            $this->path(rtrim($this->classMap[$path] ?? $path, '/'));
        }

        $this->log['summary'] = sprintf('Preloaded %d classes in %.03f seconds', static::$count, microtime(true) - $time);

        return $this;
    }

    /**
     * @return array
     */
    public function log(): array
    {
        return $this->log;
    }

    /**
     * @param string $path
     *
     * @return void
     */
    private function path(string $path): void
    {
        if (is_dir($path)) {
            $this->dir($path);
        } else {
            $this->file($path);
        }
    }

    /**
     * @param string $path
     *
     * @return void
     */
    private function dir(string $path): void
    {
        $handle = opendir($path);

        while ($file = readdir($handle)) {
            if (!in_array($file, ['.', '..'])) {
                $this->path($path.'/'.$file);
            }
        }

        closedir($handle);
    }

    /**
     * @param string $path
     *
     * @return void
     */
    private function file(string $path): void
    {
        $class = $this->fileMap[$path] ?? null;

        if (empty($class)) {
            return;
        }

        if ($this->ignored($class)) {
            $this->log['ignored'][] = $class;
            return;
        }

        require_once $path;

        static::$count++;

        $this->log['preloaded'][] = $class;
    }

    /**
     * @param ?string $name
     *
     * @return bool
     */
    private function ignored(?string $name): bool
    {
        if (empty($name)) {
            return true;
        }

        foreach ($this->ignores as $ignore) {
            if (strpos($name, $ignore) === 0) {
                return true;
            }
        }

        return false;
    }
}
