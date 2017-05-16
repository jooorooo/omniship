<?php
/**
 * Cart Item interface
 */
namespace Omniship\Interfaces;

use Carbon\Carbon;
use Omniship\Common\EventBag;

/**
 * Quote interface
 *
 * This interface defines the functionality that all cart items in
 * the Omniship system are to have.
 */
interface TrackingInterface extends ComponentInterface
{
    /**
     * Description of the quote
     */
    public function getDescription();
    /**
     * Shipment date
     * @return Carbon|null
     */
    public function getShipmentDate();
    /**
     * Estimated Delivery Date
     * @return Carbon|null
     */
    public function getEstimatedDeliveryDate();
    /**
     * Service Area of origin
     * @return ComponentInterface|null
     */
    public function getOriginServiceArea();
    /**
     * Service Area of destination
     * @return ComponentInterface|null
     */
    public function getDestinationServiceArea();
    /**
     * @return EventBag|null
     */
    public function getEvents();
}
