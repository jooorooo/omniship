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
use Omniship\Interfaces\ComponentInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Interfaces\ShippingServiceInterface;
use Omniship\Interfaces\TrackingInterface;
use Omniship\Traits\Parameters;

/**
 * Shipping Quote
 *
 * This class defines a single quote in the Omniship system.
 *
 * @see TrackingInterface
 */
class Tracking implements TrackingInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
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
    public function getOriginServiceArea()
    {
        return $this->getParameter('origin_service_area');
    }

    /**
     * Set the item name
     */
    public function setOriginServiceArea($value)
    {
        return $this->setParameter('origin_service_area', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getDestinationServiceArea()
    {
        return $this->getParameter('destination_service_area');
    }

    /**
     * Set the item name
     */
    public function setDestinationServiceArea($value)
    {
        return $this->setParameter('destination_service_area', $value);
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
     * @return Carbon|null
     */
    public function getShipmentDate()
    {
        return $this->getParameter('shipment_date');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setShipmentDate(Carbon $value = null)
    {
        return $this->setParameter('shipment_date', $value);
    }

    /**
     * @return Carbon|null
     */
    public function getEstimatedDeliveryDate()
    {
        return $this->getParameter('estimated_delivery_date');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setEstimatedDeliveryDate(Carbon $value = null)
    {
        return $this->setParameter('estimated_delivery_date', $value);
    }

    /**
     * @return EventBag|null
     */
    public function getEvents()
    {
        return $this->getParameter('events');
    }

    /**
     * @param  EventBag $value
     * @return $this
     */
    public function setEvents(EventBag $value = null)
    {
        return $this->setParameter('events', $value);
    }

}