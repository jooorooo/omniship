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
interface ServiceInterface extends ComponentInterface
{
    /**
     * allow fixed time
     */
    public function getSupportFixedTime();
    /**
     * allow fixed time
     */
    public function getSupportCashOnDelivery();
    /**
     * allow Insurance
     */
    public function getSupportInsurance();
    /**
     * allow Back Documents
     */
    public function getSupportBackDocuments();
    /**
     * allow Back Receipt Request
     */
    public function getSupportBackReceipt();
    /**
     * allow To Be Called
     */
    public function getSupportToBeCalled();
}
