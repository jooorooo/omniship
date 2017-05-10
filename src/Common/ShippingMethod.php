<?php
/**
 * Shipping Method
 */
namespace Omniship\Common;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Interfaces\ShippingMethodInterface;
use Omniship\Traits\Parameters;

/**
 * Shipping Method
 *
 * This class defines a shipping method to be used in the Omniship system.
 *
 * @see Issuer
 */
class ShippingMethod implements ShippingMethodInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{
    use Parameters;

    /**
     * Get shipping method id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set shipping method id
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set the shipping method name
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getCode()
    {
        return $this->getParameter('code');
    }

    /**
     * Set the shipping method code
     */
    public function setCode($value)
    {
        return $this->setParameter('code', $value);
    }
}
