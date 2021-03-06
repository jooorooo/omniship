<?php
/**
 * Shipping address
 */

namespace Omniship\Interfaces;

use Carbon\Carbon;

interface CreateBillOfLadingInterface
{
    /**
     * Get Pickup Date
     * @return null|Carbon
     */
    public function getPickupDate();
    /**
     * Get Estimated Delivery Date
     * @return null|Carbon
     */
    public function getEstimatedDeliveryDate();
    /**
     * Get Bill Of Lading Type
     * @return string
     */
    public function getBillOfLadingType();
    /**
     * Get Bill Of Lading Source (base64)
     * @return string
     */
    public function getBillOfLadingSource();
    /**
     * Get Bill Of Lading Url
     * @return string
     */
    public function getBillOfLadingUrl();
    /**
     * Get Bill ID
     * @return string|string[]
     */
    public function getBolId();
    /**
     * Get Service ID
     * @return string|string[]
     */
    public function getServiceId();
    /**
     * Total Price of the Bill
     * @return mixed
     */
    public function getTotal();
    /**
     * Insurance of the Bill
     * @return mixed
     */
    public function getInsurance();
    /**
     * get cash on delivery amount
     * @return mixed
     */
    public function getCashOnDelivery();
}
