<?php

namespace Omniship\Address;

use Omniship\Common\ParcelDimensions;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\ComponentInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;
use Omniship\Traits\ArrayAccess AS TraitArrayAccess;

class Office implements ComponentInterface, ArrayableInterface, \JsonSerializable, JsonableInterface, \ArrayAccess
{

    use Parameters, TraitArrayAccess;

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

    /**
     * Get phones
     * @return array|null
     */
    public function getPhones()
    {
        return $this->getParameter('phones');
    }

    /**
     * Set phones
     * @param $value
     * @return $this
     */
    public function setPhones($value)
    {
        return $this->setParameter('phones', $value);
    }

    /**
     * Get address
     * @return string|null
     */
    public function getAddressString()
    {
        return $this->getParameter('address_string');
    }

    /**
     * Set address
     * @param $value
     * @return $this
     */
    public function setAddressString($value)
    {
        return $this->setParameter('address_string', $value);
    }

    /**
     * Get provider
     * @return string|null
     */
    public function getProvider()
    {
        return $this->getParameter('provider');
    }

    /**
     * Set provider
     * @param $value
     * @return $this
     */
    public function setProvider($value)
    {
        return $this->setParameter('provider', $value);
    }

    /**
     * Get city ID
     * @return int|null
     */
    public function getCityId()
    {
        return $this->getParameter('city_id');
    }

    /**
     * Set city ID
     * @param int|null
     * @return $this
     */
    public function setCityId($city_id)
    {
        return $this->setParameter('city_id', $city_id);
    }

    /**
     * Get city
     * @return City|null
     */
    public function getCity()
    {
        return $this->getParameter('city');
    }

    /**
     * Set city
     * @param City|array $city
     * @return $this
     */
    public function setCity($city)
    {
        if(!($city instanceof City)) {
            $city = new City((array)$city);
        }
        return $this->setParameter('city', $city);
    }

    /**
     * Get country ID
     * @return int|null
     */
    public function getCountryId()
    {
        return $this->getParameter('country_id');
    }

    /**
     * Set country ID
     * @param int|null
     * @return $this
     */
    public function setCountryId($country_id)
    {
        return $this->setParameter('country_id', $country_id);
    }

    /**
     * Get country
     * @return Country|null
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * Set country
     * @param Country|array $country
     * @return $this
     */
    public function setCountry($country)
    {
        if(!($country instanceof Country)) {
            $country = new Country((array)$country);
        }
        return $this->setParameter('country', $country);
    }
}
