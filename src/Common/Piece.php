<?php
/**
 * Shipping Piece
 */
namespace Omniship\Common;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\PieceInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

/**
 * Shipping Piece
 *
 * This class defines a single cart piece in the Omniship system.
 *
 * @see PieceInterface
 */
class Piece implements PieceInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{
    use Parameters;

    /**
     * Get piece id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set piece id
     * @param $value
     * @return $this
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
     * Set the piece name
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }
    
    /**
     * Get piece height
     */
    public function getHeight()
    {
        return $this->getParameter('height');
    }

    /**
     * Set piece height
     * @param $value
     * @return $this
     */
    public function setHeight($value)
    {
        return $this->setParameter('height', $value);
    }

    /**
     * Get piece depth
     */
    public function getDepth()
    {
        return $this->getParameter('depth');
    }

    /**
     * Set piece depth
     * @param $value
     * @return $this
     */
    public function setDepth($value)
    {
        return $this->setParameter('depth', $value);
    }

    /**
     * Get piece width
     */
    public function getWidth()
    {
        return $this->getParameter('width');
    }

    /**
     * Set piece width
     * @param $value
     * @return $this
     */
    public function setWidth($value)
    {
        return $this->setParameter('width', $value);
    }

    /**
     * Get piece weight
     */
    public function getWeight()
    {
        return $this->getParameter('weight');
    }

    /**
     * Set piece weight
     * @param $value
     * @return $this
     */
    public function setWeight($value)
    {
        return $this->setParameter('weight', $value);
    }
}
