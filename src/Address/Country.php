<?php

namespace Omniship\Address;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\CountryInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

class Country implements CountryInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
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
}
