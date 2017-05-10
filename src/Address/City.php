<?php

namespace Omniship\Address;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\ComponentInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

class City implements ComponentInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
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
     * Get city id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set city id
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
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }
}
