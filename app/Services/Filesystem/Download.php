<?php declare(strict_types=1);

namespace App\Services\Filesystem;

use App\Services\Filesystem\Traits\DownloadUpload as DownloadUploadTrait;
use App\Services\Http\Curl\Curl;

class Download
{
    use DownloadUploadTrait;

    /**
     * @var string
     */
    protected string $url;

    /**
     * @param string $url
     * @param string $folder
     * @param string $name
     *
     * @return self
     */
    public function __construct(string $url, string $folder, string $name)
    {
        $this->nameOriginal = $name;

        $this->url($url);
        $this->setFolder($folder);
        $this->setPath();
        $this->setName($name, false, false);
        $this->setFile();
        $this->setPublic();
    }

    /**
     * @param bool $overwrite
     *
     * @return self
     */
    public function overwrite(bool $overwrite): self
    {
        $this->setName($this->nameOriginal, false, $overwrite);
        $this->setFile();
        $this->setPublic();

        return $this;
    }

    /**
     * @param string $url
     *
     * @return self
     */
    protected function url(string $url): self
    {
        $this->url = explode('?', $url)[0];

        return $this;
    }

    /**
     * @return self
     */
    public function download(): self
    {
        Directory::create($this->file, true);

        if ($contents = $this->contents($this->url)) {
            file_put_contents($this->file, $contents, LOCK_EX);
        }

        return $this;
    }

    /**
     * @return ?string
     */
    protected function contents(): ?string
    {
        return Curl::new()->setUrl($this->url)->send()->getBody();
    }

    /**
     * @return bool
     */
    public function exists(): bool
    {
        clearstatcache(true, $this->file);

        return is_file($this->file);
    }
}
