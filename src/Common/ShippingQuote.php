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
use Omniship\Interfaces\ShippingQuoteInterface;
use Omniship\Traits\Parameters;

/**
 * Shipping Quote
 *
 * This class defines a single quote in the Omniship system.
 *
 * @see ShippingQuoteInterface
 */
class ShippingQuote implements ShippingQuoteInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
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
     * Set the item name
     * @param $value
     * @return $this
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
     * @param $value
     * @return $this
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
     * @param mixed $value
     * @return $this
     */
    public function setPrice($value = null)
    {
        return $this->setParameter('price', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getTax()
    {
        return $this->getParameter('tax');
    }

    /**
     * Set tax
     * @param mixed $value
     * @return $this
     */
    public function setTax($value = null)
    {
        return $this->setParameter('tax', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getInsurance()
    {
        return $this->getParameter('insurance');
    }

    /**
     * Set Insurance
     * @param mixed $value
     * @return $this
     */
    public function setInsurance($value = null)
    {
        return $this->setParameter('insurance', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getCashOnDelivery()
    {
        return $this->getParameter('cash_on_delivery');
    }

    /**
     * Set cash on delivery amount
     * @param mixed $value
     * @return $this
     */
    public function setCashOnDelivery($value = null)
    {
        return $this->setParameter('cash_on_delivery', $value);
    }

    /**
     * @return Carbon|null
     */
    public function getPickupDate()
    {
        return $this->getParameter('pickup_date');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setPickupDate(Carbon $value = null)
    {
        return $this->setParameter('pickup_date', $value);
    }

    /**
     * @return Carbon|null
     */
    public function getPickupTime()
    {
        return $this->getParameter('pickup_time');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setPickupTime(Carbon $value = null)
    {
        return $this->setParameter('pickup_time', $value);
    }

    /**
     * @return Carbon|null
     */
    public function getDeliveryDate()
    {
        return $this->getParameter('delivery_date');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setDeliveryDate(Carbon $value = null)
    {
        return $this->setParameter('delivery_date', $value);
    }

    /**
     * @return Carbon|null
     */
    public function getDeliveryTime()
    {
        return $this->getParameter('delivery_time');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setDeliveryTime(Carbon $value = null)
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

    /**
     * @return string
     */
    public function getExchangeRate()
    {
        return strtoupper($this->getParameter('exchange_rate'));
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setExchangeRate($value)
    {
        return $this->setParameter('exchange_rate', $value);
    }

    /**
     * @return string
     */
    public function getPayer()
    {
        return strtoupper($this->getParameter('payer'));
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setPayer($value)
    {
        return $this->setParameter('payer', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowanceFixedTimeDelivery()
    {
        return (bool)$this->getParameter('allowance_fixed_time_delivery');
    }

    /**
     * Set Insurance
     * @param mixed $value
     * @return $this
     */
    public function setAllowanceFixedTimeDelivery($value = null)
    {
        return $this->setParameter('allowance_fixed_time_delivery', (bool)$value);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowanceCashOnDelivery()
    {
        return (bool)$this->getParameter('allowance_cash_on_delivery');
    }

    /**
     * Set Insurance
     * @param mixed $value
     * @return $this
     */
    public function setAllowanceCashOnDelivery($value = null)
    {
        return $this->setParameter('allowance_cash_on_delivery', (bool)$value);
    }

    /**
     * {@inheritDoc}
     */
    public function getAllowanceInsurance()
    {
        return (bool)$this->getParameter('allowance_insurance');
    }

    /**
     * Set Insurance
     * @param mixed $value
     * @return $this
     */
    public function setAllowanceInsurance($value = null)
    {
        return $this->setParameter('allowance_insurance', (bool)$value);
    }

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return $this->getParameter('type') ? : 'calculator';
    }

    /**
     * Set Insurance
     * @param mixed $value
     * @return $this
     */
    public function setType($value = null)
    {
        return $this->setParameter('type', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getErrorMessage()
    {
        return $this->getParameter('error_message');
    }

    /**
     * Set Error message
     * @param null|string $value
     * @return $this
     */
    public function setErrorMessage($value = null)
    {
        return $this->setParameter('error_message', $value);
    }

}