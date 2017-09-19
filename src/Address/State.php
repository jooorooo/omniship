<?php

namespace Omniship\Address;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Interfaces\StateInterface;
use Omniship\Traits\Parameters;
use Omniship\Traits\ArrayAccess AS TraitArrayAccess;

class State implements StateInterface, ArrayableInterface, \JsonSerializable, JsonableInterface, \ArrayAccess
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
     * Get state id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set state id
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * Get state name
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set state name
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
}
