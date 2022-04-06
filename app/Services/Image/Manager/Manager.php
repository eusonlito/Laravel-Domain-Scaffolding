<?php declare(strict_types=1);

namespace App\Services\Image\Manager;

use Imagick;
use ImagickPixel;

class Manager
{
    /**
     * @const
     */
    protected const DPI_DEFAULT = 72;

    /**
     * @var \Imagick
     */
    protected Imagick $image;

    /**
     * @param int $width
     * @param int $height
     * @param string $format = 'png'
     * @param int $dpi = 0
     *
     * @return self
     */
    public static function empty(int $width, int $height, string $format = 'png', int $dpi = 0): self
    {
        $image = new Imagick();

        $image->newImage($width, $height, new ImagickPixel('white'));
        $image->setFormat($format);

        return new self($image, $dpi);
    }

    /**
     * @param string $file
     * @param int $dpi = 0
     *
     * @return self
     */
    public static function file(string $file, int $dpi = 0): self
    {
        $image = new Imagick();

        $image->readImage($file);

        return new self($image, $dpi);
    }

    /**
     * @param \Imagick $image
     * @param int $dpi = 0
     *
     * @return self
     */
    public function __construct(Imagick $image, int $dpi = 0)
    {
        $this->image($image, $dpi);
    }

    /**
     * @param \Imagick $image
     * @param int $dpi
     *
     * @return self
     */
    protected function image(Imagick $image, int $dpi): self
    {
        $dpi = $dpi ?: static::DPI_DEFAULT;

        $this->image = $image;

        $this->image->stripImage();
        $this->image->setImageUnits(Imagick::RESOLUTION_PIXELSPERINCH);
        $this->image->setImageResolution($dpi, $dpi);

        return $this;
    }

    /**
     * @param int $maxWidth
     * @param int $maxHeight
     *
     * @return self
     */
    public function resize(int $maxWidth, int $maxHeight): self
    {
        $this->image = Resize::new($this->image)->handle($maxWidth, $maxHeight)->image();

        return $this;
    }

    /**
     * @param int $percent = 1
     *
     * @return self
     */
    public function trim(int $percent = 1): self
    {
        $this->image = Trim::new($this->image)->handle($percent)->image();

        return $this;
    }

    /**
     * @return self
     */
    public function watermark(): self
    {
        $this->image = Watermark::new($this->image)->handle()->image();

        return $this;
    }

    /**
     * @return self
     */
    public function square(): self
    {
        $this->image = Square::new($this->image)->handle()->image();

        return $this;
    }

    /**
     * @return array
     */
    public function geometry(): array
    {
        return $this->image->getImageGeometry();
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return (string)$this->image;
    }

    /**
     * @return string
     */
    public function base64(): string
    {
        return 'data:image/jpeg;base64,'.base64_encode($this->render());
    }

    /**
     * @param string $path
     *
     * @return self
     */
    public function save(string $path): self
    {
        $dir = dirname($path);

        clearstatcache(true, $dir);

        if (is_dir($dir) === false) {
            mkdir($dir, 0755, true);
        }

        file_put_contents($path, (string)$this->image);

        return $this;
    }
}
