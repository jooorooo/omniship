<?php
/**
 * Cart Item interface
 */
namespace Omniship\Interfaces;
use Carbon\Carbon;

/**
 * Quote interface
 *
 * This interface defines the functionality that all cart items in
 * the Omniship system are to have.
 */
interface ShippingQuoteInterface extends ComponentInterface
{
    /**
     * Description of the quote
     */
    public function getDescription();
    /**
     * Price of the quote
     * @return mixed
     */
    public function getPrice();
    /**
     * Tax of the quote
     * @return mixed
     */
    public function getTax();
    /**
     * Insurance of the quote
     * @return mixed
     */
    public function getInsurance();
    /**
     * get cash on delivery amount
     * @return mixed
     */
    public function getCashOnDelivery();
    /**
     * Pickup date of the quote
     * @return Carbon|null
     */
    public function getPickupDate();
    /**
     * Pickup time of the quote
     * @return Carbon|null
     */
    public function getPickupTime();
    /**
     * Delivery Date of the quote
     * @return Carbon|null
     */
    public function getDeliveryDate();
    /**
     * Delivery Time of the quote
     * @return Carbon|null
     */
    public function getDeliveryTime();
    /**
     * Currency of the quote
     * @return string
     */
    public function getCurrency();

    /**
     * @return string
     */
    public function getExchangeRate();

    /**
     * @return string
     */
    public function getPayer();

    /**
     * @return boolean
     */
    public function getAllowanceFixedTimeDelivery();

    /**
     * @return boolean
     */
    public function getAllowanceCashOnDelivery();

    /**
     * @return boolean
     */
    public function getAllowanceInsurance();
}
