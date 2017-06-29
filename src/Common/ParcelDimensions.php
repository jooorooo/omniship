<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 29.6.2017 г.
 * Time: 15:28 ч.
 */

namespace Omniship\Common;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

class ParcelDimensions implements ArrayableInterface, \JsonSerializable, JsonableInterface
{

    use Parameters;

    /**
     * Get parcel width
     */
    public function getWidth()
    {
        return $this->getParameter('width');
    }

    /**
     * Set parcel width
     * @param $value
     * @return $this
     */
    public function setWidth($value)
    {
        return $this->setParameter('width', $value);
    }

    /**
     * Get parcel height
     */
    public function getHeight()
    {
        return $this->getParameter('height');
    }

    /**
     * Set parcel height
     * @param $value
     * @return $this
     */
    public function setHeight($value)
    {
        return $this->setParameter('height', $value);
    }

    /**
     * Get parcel length
     */
    public function getLength()
    {
        return $this->getParameter('length');
    }

    /**
     * Set parcel length
     * @param $value
     * @return $this
     */
    public function setLength($value)
    {
        return $this->setParameter('length', $value);
    }

}