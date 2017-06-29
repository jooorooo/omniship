<?php

namespace Omniship\Address;

use Omniship\Common\ParcelDimensions;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\ComponentInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

class Office implements ComponentInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{

    use Parameters;

    /**
     * Create a new item with the specified parameters
     *
     * @param array|null $parameters An array of parameters to set on the new object
     */
    public function __construct(array $parameters = null)
    {
        $this->initialize($parameters);
    }

    /**
     * Get office id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set office id
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * Get office name
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set office name
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * Get office max allowed weight
     */
    public function getMaxWeight()
    {
        return $this->getParameter('max_weight');
    }

    /**
     * Set office max allowed weight
     * @param $value
     * @return $this
     */
    public function setMaxWeight($value)
    {
        return $this->setParameter('max_weight', $value);
    }

    /**
     * Get office weight unit
     */
    public function getWeightUnit()
    {
        return $this->getParameter('weight_unit');
    }

    /**
     * Set office weight unit
     * @param $value
     * @return $this
     */
    public function setWeightUnit($value)
    {
        return $this->setParameter('weight_unit', $value);
    }

    /**
     * Get office max allowed Dimensions
     * @return null|ParcelDimensions
     */
    public function getMaxParcelDimensions()
    {
        return $this->getParameter('max_parcel_dimensions');
    }

    /**
     * Set office max allowed Dimensions
     * @param $value
     * @return $this
     */
    public function setMaxParcelDimensions($value = null)
    {
        if(is_array($value)) {
            $value = new ParcelDimensions($value);
        } elseif(!($value instanceof ParcelDimensions)) {
            $value = null;
        }
        return $this->setParameter('max_parcel_dimensions', $value);
    }

    /**
     * Get office dimension unit
     */
    public function getDimensionUnit()
    {
        return $this->getParameter('dimension_unit');
    }

    /**
     * Set office dimension unit
     * @param $value
     * @return $this
     */
    public function setDimensionUnit($value)
    {
        return $this->setParameter('dimension_unit', $value);
    }

    /**
     * Get office latitude
     */
    public function getLatitude()
    {
        return $this->getParameter('latitude');
    }

    /**
     * Set office latitude
     * @param $value
     * @return $this
     */
    public function setLatitude($value)
    {
        return $this->setParameter('latitude', $value);
    }

    /**
     * Get office longitude
     */
    public function getLongitude()
    {
        return $this->getParameter('longitude');
    }

    /**
     * Set office longitude
     * @param $value
     * @return $this
     */
    public function setLongitude($value)
    {
        return $this->setParameter('longitude', $value);
    }

    /**
     * Get office type
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * Set office type
     * @param $value
     * @return $this
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }
}
