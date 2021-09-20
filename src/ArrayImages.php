<?php

namespace Halimtuhu\ArrayImages;

use Laravel\Nova\Fields\Field;

class ArrayImages extends Field
{
    /**
     * The field's component.
     *
     * @var string
     */
    public $component = 'array-images';

    /**
     * Specify target disk
     *
     * @param $disk
     * @return ArrayImages
     */
    public function disk($disk)
    {
        return $this->withMeta([
            'disk' => $disk
        ]);
    }

    /**
     * Specify target path
     *
     * @param $path
     * @return ArrayImages
     */
    public function path($path)
    {
        return $this->withMeta([
            'path' => $path
        ]);
    }

    /**
     * Resize the images
     *
     * @param int|null $width
     * @param int|null $height
     * @param bool $aspectRatio
     * @return ArrayImages
     */
    public function resize(int $width = null, int $height = null, bool $aspectRatio = false)
    {
        return $this->withMeta([
            'resize' => "$width*$height:$aspectRatio"
        ]);
    }
}
