<?php declare(strict_types=1);

namespace App\Services\Filesystem;

use Illuminate\Http\UploadedFile;
use App\Services\Filesystem\Traits\DownloadUpload as DownloadUploadTrait;

class Upload
{
    use DownloadUploadTrait;

    /**
     * @var \Illuminate\Http\UploadedFile
     */
    protected UploadedFile $upload;

    /**
     * @param \Illuminate\Http\UploadedFile $upload
     * @param string $folder
     * @param string $name
     *
     * @return self
     */
    public function __construct(UploadedFile $upload, string $folder, string $name)
    {
        $this->upload = $upload;
        $this->nameOriginal = $name;

        $this->setFolder($folder);
        $this->setPath();
        $this->setName($name, $upload->clientExtension(), false);
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
        $this->setName($this->nameOriginal, $this->upload->clientExtension(), $overwrite);
        $this->setFile();
        $this->setPublic();

        return $this;
    }

    /**
     * @return self
     */
    public function upload(): self
    {
        Directory::create($this->file, true);

        move_uploaded_file($this->upload->path(), $this->file);

        return $this;
    }
}
