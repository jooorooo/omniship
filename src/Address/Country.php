<?php

namespace Omniship\Address;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\CountryInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;
use Omniship\Traits\ArrayAccess AS TraitArrayAccess;

class Country implements CountryInterface, ArrayableInterface, \JsonSerializable, JsonableInterface, \ArrayAccess
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
     * Get country id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set country id
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * Get country name
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set country name
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * Get iso2
     */
    public function getIso2()
    {
        return $this->getParameter('iso2');
    }

    /**
     * Set iso2
     * @param $value
     * @return $this
     */
    public function setIso2($value)
    {
        return $this->setParameter('iso2', $value);
    }

    /**
     * Get iso3
     */
    public function getIso3()
    {
        return $this->getParameter('iso3');
    }

    /**
     * Set iso3
     * @param $value
     * @return $this
     */
    public function setIso3($value)
    {
        return $this->setParameter('iso3', $value);
    }

    /**
     * Get currency
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }

    /**
     * Set currency
     * @param $value
     * @return $this
     */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

    /**
     * Get is require post code
     */
    public function getRequirePostCode()
    {
        return $this->getParameter('require_post_code');
    }

    /**
     * Set is require post code
     * @param $value
     * @return $this
     */
    public function setRequirePostCode($value)
    {
        return $this->setParameter('require_post_code', $value);
    }

    /**
     * Get is state require
     */
    public function getRequireState()
    {
        return $this->getParameter('require_state');
    }

    /**
     * Set state require
     * @param $value
     * @return $this
     */
    public function setRequireState($value)
    {
        return $this->setParameter('require_state', $value);
    }



    /**
     * Get has cities nomenclature
     */
    public function getHasCities()
    {
        return $this->getParameter('has_cities');
    }

    /**
     * Set has cities nomenclature
     * @param $value
     * @return $this
     */
    public function setHasCities($value)
    {
        return $this->setParameter('has_cities', $value);
    }
}
