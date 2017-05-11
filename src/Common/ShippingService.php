<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 18:16 ч.
 */

namespace Omniship\Common;

use Carbon\Carbon;
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
class ShippingService implements QuoteInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
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
     * Tax of the quote
     */
    public function getTax()
    {
        return $this->getParameter('tax');
    }

    /**
     * Set tax
     */
    public function setTax($value)
    {
        return $this->setParameter('tax', $value);
    }

    /**
     * Insurance of the quote
     */
    public function getInsurance()
    {
        return $this->getParameter('insurance');
    }

    /**
     * Set Insurance
     */
    public function setInsurance($value)
    {
        return $this->setParameter('insurance', $value);
    }

    /**
     * @return Carbon
     */
    public function getPickupDate()
    {
        return $this->getParameter('pickup_date');
    }

    /**
     * @param  Carbon $value
     * @return $this
     */
    public function setPickupDate(Carbon $value)
    {
        return $this->setParameter('pickup_date', $value);
    }

    /**
     * @return Carbon
     */
    public function getPickupTime()
    {
        return $this->getParameter('pickup_time');
    }

    /**
     * @param  Carbon $value
     * @return $this
     */
    public function setPickupTime(Carbon $value)
    {
        return $this->setParameter('pickup_time', $value);
    }

    /**
     * @return Carbon
     */
    public function getDeliveryDate()
    {
        return $this->getParameter('delivery_date');
    }

    /**
     * @param  Carbon $value
     * @return $this
     */
    public function setDeliveryDate(Carbon $value)
    {
        return $this->setParameter('delivery_date', $value);
    }

    /**
     * @return Carbon
     */
    public function getDeliveryTime()
    {
        return $this->getParameter('delivery_time');
    }

    /**
     * @param  Carbon $value
     * @return $this
     */
    public function setDeliveryTime(Carbon $value)
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