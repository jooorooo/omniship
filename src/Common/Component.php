<?php
/**
 * Component
 */
namespace Omniship\Common;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\ComponentInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

/**
 * Shipping Item
 *
 * This class defines a single cart item in the Omniship system.
 *
 * @see ComponentInterface
 */
class Component implements ComponentInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{
    use Parameters;

    /**
     * Get item id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set item id
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
     * Set the item name
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }
}
