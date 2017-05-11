<?php
/**
 * Cart Item interface
 */
namespace Omniship\Interfaces;

/**
 * Quote interface
 *
 * This interface defines the functionality that all cart items in
 * the Omniship system are to have.
 */
interface QuoteInterface extends ComponentInterface
{
    /**
     * Description of the quote
     */
    public function getDescription();
    /**
     * Price of the quote
     */
    public function getPrice();
    /**
     * Tax of the quote
     */
    public function getTax();
    /**
     * Insurance of the quote
     */
    public function getInsurance();
    /**
     * Pickup date of the quote
     */
    public function getPickupDate();
    /**
     * Pickup time of the quote
     */
    public function getPickupTime();
    /**
     * Delivery Date of the quote
     */
    public function getDeliveryDate();
    /**
     * Delivery Time of the quote
     */
    public function getDeliveryTime();
    /**
     * Currency of the quote
     */
    public function getCurrency();
}
