<?php declare(strict_types=1);

namespace App\Services\Image\Manager;

use Imagick;

abstract class ManagerAbstract
{
    /**
     * @var \Imagick
     */
    protected Imagick $image;

    /**
     * @param \Imagick $image
     *
     * @return self
     */
    public static function new(Imagick $image): self
    {
        $class = static::class;

        return new $class($image);
    }

    /**
     * @param \Imagick $image
     *
     * @return self
     */
    public function __construct(Imagick $image)
    {
        $this->image = $image;
    }

    /**
     * @return \Imagick
     */
    public function image(): Imagick
    {
        return $this->image;
    }
}
