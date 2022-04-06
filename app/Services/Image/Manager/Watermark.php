<?php declare(strict_types=1);

namespace App\Services\Image\Manager;

use Imagick;

class Watermark extends ManagerAbstract
{
    /**
     * @return self
     */
    public function handle(): self
    {
        $width = intval($this->image->getImageWidth() / 5);
        $height = intval($this->image->getImageHeight() / 5);

        $watermark = new Imagick();
        $watermark->readImage(base_path('resources/views/assets/images/logo-watermark.png'));

        $watermark->resizeImage($width, $height, Imagick::FILTER_CATROM, 0.5);
        $watermark->setImagePage(0, 0, 0, 0);

        $watermark->evaluateImage(Imagick::EVALUATE_MULTIPLY, 0.02, Imagick::CHANNEL_ALPHA);

        for ($i = 0; $i < 5; $i++) {
            for ($j = 0; $j < 5; $j++) {
                $this->image->compositeImage($watermark, $watermark->getImageCompose(), $width * $i, $height * $j);
            }
        }

        return $this;
    }
}
