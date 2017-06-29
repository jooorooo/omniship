<?php
/**
 * Shipping gateway interface
 */

namespace Omniship\Interfaces;
use Carbon\Carbon;
use Omniship\Common\Address;

/**
 * Shipping gateway interface
 *
 * This interface class defines the standard functions that any
 * Omniship gateway needs to define.
 *
 * @see AbstractGateway
 *
 * @method RequestInterface getServices(array $parameters = [])         (Optional method)
 *         Get shipping quotes
 * @method RequestInterface getQuotes(array $parameters = [])         (Optional method)
 *         Get shipping quotes
 * @method RequestInterface createBillOfLading(array $parameters = [])  (Optional method)
 *         Create Bill Of Lading
 * @method RequestInterface cancelBillOfLading($bol_id, $cancelComment=null)  (Optional method)
 *         Cancel Bill Of Lading
 * @method RequestInterface deleteBillOfLading()  (Optional method)
 *         Delete Bill Of Lading
 * @method RequestInterface trackingParcel($bol_id)      (Optional method)
 *         Tracking Parcel
 * @method RequestInterface trackingParcels(array $bol_ids = [])      (Optional method)
 *         Tracking Parcel
 * @method RequestInterface validateCredentials(array $parameters = [], $test_mode = null)      (Optional method)
 *         Tracking Parcel
 * @method RequestInterface validateAddress(Address $address)   (Optional method)
 *         Validate address
 * @method RequestInterface validatePostCode(Address $address)      (Optional method)
 *         Tracking Parcel
 * @method RequestInterface requestCourier($bol_id, Carbon $date_start = null, Carbon $date_end = null)      (Optional method)
 *         Tracking Parcel
 * @method RequestInterface codPayment($bol_id)      (Optional method)
 *         COD payment information
 * @method RequestInterface codPayments(array $bol_ids)      (Optional method)
 *         multiple COD payment information
 * @method mixed getClient()      (Optional method)
 *         client with other methods where not defined in \Omniship\Common\AbstractGateway
 * @method RequestInterface getPdf($bol_id)      (Optional method)
 *         get pdf content
 */
interface GatewayInterface
{
    /**
     * Get gateway display name
     *
     * This can be used by carts to get the display name for each gateway.
     */
    public function getName();
    /**
     * Get gateway short name
     *
     * This name can be used with GatewayFactory as an alias of the gateway class,
     * to create new instances of this gateway.
     */
    public function getShortName();
    /**
     * Define gateway parameters, in the following format:
     *
     * array(
     *     'username' => '', // string variable
     *     'testMode' => false, // boolean variable
     * );
     */
    public function getDefaultParameters();
    /**
     * Initialize gateway with parameters
     * @param array $parameters
     */
    public function initialize(array $parameters = array());
    /**
     * Get all gateway parameters
     *
     * @return array
     */
    public function getParameters();
}
