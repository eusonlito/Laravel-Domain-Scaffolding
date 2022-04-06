<?php declare(strict_types=1);

namespace App\Services\Image;

use App\Services\Filesystem\Download as DownloadFilesystem;
use App\Services\Image\Manager\Manager;

class Download
{
    /**
     * @const int
     */
    protected const MAX_WIDTH = 4096;

    /**
     * @const int
     */
    protected const MAX_HEIGHT = 4096;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var int
     */
    protected int $trim = 0;

    /**
     * @var bool
     */
    protected bool $square = false;

    /**
     * @var bool
     */
    protected bool $overwrite = false;

    /**
     * @var bool
     */
    protected bool $skipIfExists = false;

    /**
     * @var \App\Services\Filesystem\Download
     */
    protected DownloadFilesystem $filesystem;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $url
     * @param string $path
     * @param string $name
     *
     * @return self
     */
    public function __construct(string $url, string $path, string $name)
    {
        $this->url = $url;
        $this->path = $path;
        $this->name = $name;
    }

    /**
     * @param bool $overwrite
     *
     * @return self
     */
    public function overwrite(bool $overwrite): self
    {
        $this->overwrite = $overwrite;

        return $this;
    }

    /**
     * @param int $trim
     *
     * @return self
     */
    public function trim(int $trim): self
    {
        $this->trim = $trim;

        return $this;
    }

    /**
     * @param bool $square
     *
     * @return self
     */
    public function square(bool $square): self
    {
        $this->square = $square;

        return $this;
    }

    /**
     * @param bool $skipIfExists
     *
     * @return self
     */
    public function skipIfExists(bool $skipIfExists): self
    {
        $this->skipIfExists = $skipIfExists;

        return $this;
    }

    /**
     * @return self
     */
    public function download(): self
    {
        $filesystem = $this->filesystem();

        if ($this->skipIfExists && $filesystem->exists()) {
            return $this;
        }

        $filesystem->download();

        $manager = Manager::file($filesystem->getFile());

        if ($this->trim) {
            $manager->trim($this->trim);
        }

        if ($this->square) {
            $manager->square();
        }

        $manager->resize(static::MAX_WIDTH, static::MAX_HEIGHT)
            ->save($filesystem->getFile());

        return $this;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->filesystem()->getFile();
    }

    /**
     * @return string
     */
    public function getPublic(): string
    {
        return $this->filesystem()->getPublic();
    }

    /**
     * @return \App\Services\Filesystem\Download
     */
    protected function filesystem(): DownloadFilesystem
    {
        return $this->filesystem ??= DownloadFilesystem::new($this->url, $this->path, $this->name)
            ->overwrite($this->overwrite);
    }
}
