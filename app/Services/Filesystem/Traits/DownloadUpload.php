<?php declare(strict_types=1);

namespace App\Services\Filesystem\Traits;

trait DownloadUpload
{
    /**
     * @var string
     */
    protected string $folder;

    /**
     * @var string
     */
    protected string $path;

    /**
     * @var string
     */
    protected string $name;

    /**
     * @var string
     */
    protected string $nameOriginal;

    /**
     * @var string
     */
    protected string $file;

    /**
     * @var string
     */
    protected string $public;

    /**
     * @return self
     */
    public static function new(): self
    {
        return new static(...func_get_args());
    }

    /**
     * @param string $folder
     *
     * @return self
     */
    protected function setFolder(string $folder): self
    {
        $this->folder = '/storage/'.implode('/', array_filter(array_map('str_slug', explode('/', $folder))));

        return $this;
    }

    /**
     * @return self
     */
    protected function setPath(): self
    {
        $this->path = public_path($this->folder);

        return $this;
    }

    /**
     * @param string $name
     * @param string|bool $extension
     * @param bool $overwrite
     *
     * @return self
     */
    protected function setName(string $name, string|bool $extension, bool $overwrite): self
    {
        if ($extension === false) {
            [$extension, $name] = array_reverse(explode('.', $name, 2));
        }

        $name = str_slug($name);
        $extension = strtolower($extension);

        $this->name = $name.'.'.$extension;

        if ($overwrite === false) {
            $this->setNameDifferent($name, $extension);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param string $extension
     *
     * @return self
     */
    protected function setNameDifferent(string $name, string $extension): self
    {
        $count = 0;

        while (is_file($this->path.'/'.$this->name)) {
            $this->name = $name.'-'.(++$count).'.'.$extension;
        }

        return $this;
    }

    /**
     * @return self
     */
    protected function setFile(): self
    {
        $this->file = $this->path.'/'.$this->name;

        return $this;
    }

    /**
     * @return self
     */
    protected function setPublic(): self
    {
        $this->public = $this->folder.'/'.$this->name;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getPublic(): string
    {
        return $this->public;
    }

    /**
     * @return string
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return $this->file;
    }
}
