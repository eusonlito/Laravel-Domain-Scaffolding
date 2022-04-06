<?php declare(strict_types=1);

namespace App\Services\Image\Manager;

class Square extends ManagerAbstract
{
    /**
     * @return self
     */
    public function handle(): self
    {
        $width = $this->image->getImageWidth();
        $height = $this->image->getImageHeight();

        if ($width === $height) {
            return $this;
        }

        $size = max($width, $height);

        $this->image->setImageBackgroundColor('white');
        $this->image->extentImage($size, $size, intval(($width - $size) / 2), intval(($height - $size) / 2));
        $this->image->setImagePage(0, 0, 0, 0);

        return $this;
    }
}
