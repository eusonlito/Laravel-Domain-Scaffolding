<?php declare(strict_types=1);

namespace App\Services\Image\Manager;

use Imagick;

class Resize extends ManagerAbstract
{
    /**
     * @param int $maxWidth
     * @param int $maxHeight
     *
     * @return self
     */
    public function handle(int $maxWidth, int $maxHeight): self
    {
        $width = $this->image->getImageWidth();
        $height = $this->image->getImageHeight();

        if (($width <= $maxWidth) && ($height <= $maxHeight)) {
            return $this;
        }

        if ($width > $height) {
            $maxHeight = (int)round($height * $maxWidth / $width, 0);
        } else {
            $maxWidth = (int)round($width * $maxHeight / $height, 0);
        }

        $this->image->resizeImage($maxWidth, $maxHeight, Imagick::FILTER_CATROM, 0.5);
        $this->image->setImagePage(0, 0, 0, 0);

        return $this;
    }
}
