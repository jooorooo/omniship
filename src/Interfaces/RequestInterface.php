<?php
/**
 * Request Interface
 */
namespace Omniship\Interfaces;
use Carbon\Carbon;
use Money\Money;
use Omniship\Common\Address;
use Omniship\Exceptions\InvalidRequestException;
use Symfony\Component\HttpFoundation\ParameterBag;

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
     * @return string
     */
    public function getServiceId();
    /**
     * @return Address
     */
    public function getAddress();

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
    public function getShipmentDate();
    /**
     * @return boolean
     */
    public function getTestMode();
    /**
     * Get pickup ID
     *
     * @return mixed
     */
    public function getBolId();
    /**
     * @param $key
     * @return mixed|ParameterBag
     */
    public function getOtherParameters($key = null);
    /**
     * Get the request date.
     *
     * @return null|Carbon
     */
    public function getStartDate();
    /**
     * Get the request date.
     *
     * @return null|Carbon
     */
    public function getEndDate();
    /**
     * @return Carbon
     */
    public function getPriorityTime();
    /**
     * @return Carbon
     */
    public function getPriorityTimeType();
    /**
     * @return array|null
     */
    public function getAllowedServices();
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
