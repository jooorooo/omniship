<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 18:16 ч.
 */

namespace Omniship\Common;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Interfaces\QuoteInterface;
use Omniship\Traits\Parameters;

/**
 * Shipping Quote
 *
 * This class defines a single quote in the Omniship system.
 *
 * @see QuoteInterface
 */
class Quote implements QuoteInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
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

    /**
     * {@inheritDoc}
     */
    public function getDescription()
    {
        return $this->getParameter('description');
    }

    /**
     * Set the item description
     */
    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrice()
    {
        return $this->getParameter('price');
    }

    /**
     * Set the item price
     */
    public function setPrice($value)
    {
        return $this->setParameter('price', $value);
    }

    /**
     * @return string
     */
    public function getPickupDate()
    {
        return $this->getParameter('pickup_date');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setPickupDate($value)
    {
        return $this->setParameter('pickup_date', $value);
    }

    /**
     * @return string
     */
    public function getPickupTime()
    {
        return $this->getParameter('pickup_time');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setPickupTime($value)
    {
        return $this->setParameter('pickup_time', $value);
    }

    /**
     * @return string
     */
    public function getDeliveryDate()
    {
        return $this->getParameter('delivery_date');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setDeliveryDate($value)
    {
        return $this->setParameter('delivery_date', $value);
    }

    /**
     * @return string
     */
    public function getDeliveryTime()
    {
        return $this->getParameter('delivery_time');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setDeliveryTime($value)
    {
        return $this->setParameter('delivery_time', $value);
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->getParameter('currency'));
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
    }

}