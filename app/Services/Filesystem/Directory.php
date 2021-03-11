<?php declare(strict_types=1);

namespace App\Services\Filesystem;

use Generator;

class Directory
{
    /**
     * @param string $dir
     * @param array $extensions = []
     * @param ?array $exclude = null
     *
     * @return \Generator
     */
    public static function files(string $dir, array $extensions = [], ?array $exclude = null): Generator
    {
        if (is_dir($dir) === false) {
            return [];
        }

        $dh = opendir($dir);

        while (($file = readdir($dh)) !== false) {
            if (($file === '.') || ($file === '..')) {
                continue;
            }

            $file = $dir.'/'.$file;

            if (is_dir($file)) {
                yield from static::files($file, $extensions, $exclude);
            }

            if (static::filesValid($file, $extensions, $exclude)) {
                yield $file;
            }
        }

        closedir($dh);

        return [];
    }

    /**
     * @param string $file
     * @param ?array $extensions = []
     * @param ?array $exclude = []
     *
     * @return bool
     */
    protected static function filesValid(string $file, ?array $extensions = [], ?array $exclude = []): bool
    {
        return is_file($file)
            && (($extensions === null) || preg_match('/\.('.implode('|', $extensions).')$/', $file))
            && (($exclude === null) || ($file === str_replace($exclude, '', $file)));
    }

    /**
     * @param string $dir
     * @param bool $file = false
     *
     * @return string
     */
    public static function create(string $dir, bool $file = false): string
    {
        if ($file) {
            $dir = dirname($dir);
        }

        if (is_dir($dir) === false) {
            mkdir($dir, 0755, true);
        }

        return $dir;
    }
}
