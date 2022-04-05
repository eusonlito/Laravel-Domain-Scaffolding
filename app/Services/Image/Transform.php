<?php declare(strict_types=1);

namespace App\Services\Image;

use Packer;

class Transform
{
    /**
     * @param string $image
     * @param string $transform
     * @param ?string $target = null
     *
     * @return string
     */
    public static function image(string $image, string $transform = '', ?string $target = null): string
    {
        if (empty($transform) && empty($target)) {
            return asset($image);
        }

        return (string)Packer::img($image, static::transform($transform), $target);
    }

    /**
     * @param string $transform
     *
     * @return string
     */
    protected static function transform(string $transform): string
    {
        if (strstr($transform, 'resizeCrop') && (substr_count($transform, ',') === 2)) {
            $transform .= ',CROP_ENTROPY';
        }

        return $transform;
    }
}
