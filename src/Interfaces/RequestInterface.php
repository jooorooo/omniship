<?php
/**
 * Request Interface
 */
namespace Omniship\Interfaces;
use Carbon\Carbon;
use Money\Money;
use Omniship\Common\Address;
use Omniship\Exceptions\InvalidRequestException;

/**
 * Request Interface
 *
 * This interface class defines the standard functions that any Omniship request
 * interface needs to be able to provide.  It is an extension of MessageInterface.
 *
 * @see MessageInterface
 */
interface RequestInterface extends MessageInterface
{
    /**
     * Initialize request with parameters
     * @param array $parameters The parameters to send
     */
    public function initialize(array $parameters = array());
    /**
     * Get all request parameters
     *
     * @return array
     */
    public function getParameters();
    /**
     * Get a single parameter.
     *
     * @param string $key The parameter key
     * @return mixed
     */
    public function getParameter($key);
    /**
     * @return Address
     */
    public function getReceiverAddress();
    /**
     * @return Address
     */
    public function getSenderAddress();

    /**
     * @return null|string
     */
    public function getSenderTimeZone();
    /**
     * @return null|string
     */
    public function getReceiverTimeZone();
    /**
     * @return string
     */
    public function getLanguageCode();
    /**
     * @return string
     */
    public function getCurrency();
    /**
     * Get the response to this request (if the request has been sent)
     *
     * @return ResponseInterface
     */
    public function getResponse();
    /**
     * Get pickup date
     *
     * @return null|Carbon
     */
    public function getTakingDate();
    /**
     * Get pickup ID
     *
     * @return mixed
     */
    public function getBolId();
    /**
     * Send the request
     *
     * @return ResponseInterface
     */
    public function send();
    /**
     * Send the request with specified data
     *
     * @param  mixed             $data The data to send
     * @return ResponseInterface
     */
    public function sendData($data);
}
