<?php declare(strict_types=1);

namespace App\Services\Image;

use Illuminate\Http\UploadedFile;
use App\Services\Filesystem\Upload as UploadFilesystem;
use App\Services\Image\Manager\Manager;

class Upload
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
     * @var \Illuminate\Http\UploadedFile
     */
    protected UploadedFile $file;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var \App\Services\Filesystem\Upload
     */
    protected UploadFilesystem $filesystem;

    /**
     * @var int
     */
    protected int $trim = 0;

    /**
     * @var bool
     */
    protected bool $overwrite = false;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $path
     * @param string $name
     *
     * @return self
     */
    public function __construct(UploadedFile $file, string $path, string $name)
    {
        $this->file = $file;
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
     * @return self
     */
    public function upload(): self
    {
        $manager = Manager::file($this->file->path());

        if ($this->trim) {
            $manager->trim($this->trim);
        }

        $manager->resize(static::MAX_WIDTH, static::MAX_HEIGHT)
            ->save($this->filesystem()->getFile());

        return $this;
    }

    /**
     * @return string
     */
    public function getPublic(): string
    {
        return $this->filesystem()->getPublic();
    }

    /**
     * @return \App\Services\Filesystem\Upload
     */
    protected function filesystem(): UploadFilesystem
    {
        return $this->filesystem ??= UploadFilesystem::new($this->file, $this->path, $this->name)
            ->overwrite($this->overwrite);
    }
}
