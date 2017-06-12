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
interface CodPaymentInterface
{
    /**
     * bol ID
     */
    public function getId();
    /**
     * Date
     * @return Carbon|null
     */
    public function getDate();
    /**
     * Price
     */
    public function getPrice();
}
