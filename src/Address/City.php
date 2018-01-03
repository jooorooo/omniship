<?php

namespace Omniship\Address;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\ComponentInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;
use Omniship\Traits\ArrayAccess AS TraitArrayAccess;

class City implements ComponentInterface, ArrayableInterface, \JsonSerializable, JsonableInterface, \ArrayAccess
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
     * Get city id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set city id
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * Get city name
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set city name
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * Get city ascii name
     */
    public function getAsciiName()
    {
        return $this->getParameter('ascii_name');
    }

    /**
     * Set city ascii name
     * @param $value
     * @return $this
     */
    public function setAsciiName($value)
    {
        return $this->setParameter('ascii_name', $value);
    }

    /**
     * Get city post_code
     */
    public function getPostCode()
    {
        return $this->getParameter('post_code');
    }

    /**
     * Set city post_code
     * @param $value
     * @return $this
     */
    public function setPostCode($value)
    {
        return $this->setParameter('post_code', $value);
    }

    /**
     * Get city type
     */
    public function getType()
    {
        return $this->getParameter('type');
    }

    /**
     * Set city type
     * @param $value
     * @return $this
     */
    public function setType($value)
    {
        return $this->setParameter('type', $value);
    }

    /**
     * Get city country ID
     */
    public function getCountryId()
    {
        return $this->getParameter('country_id');
    }

    /**
     * Set city country ID
     * @param $value
     * @return $this
     */
    public function setCountryId($value)
    {
        return $this->setParameter('country_id', $value);
    }

    /**
     * Get city country
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * Set city country
     * @param $value
     * @return $this
     */
    public function setCountry($value)
    {
        return $this->setParameter('country', $value);
    }
}
