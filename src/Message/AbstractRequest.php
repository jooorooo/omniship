<?php
/**
 * Abstract Request
 */
namespace Omniship\Message;

use Money\Currencies\ISOCurrencies;
use Money\Currency;
use Money\Formatter\DecimalMoneyFormatter;
use Money\Money;
use Money\Number;
use Money\Parser\DecimalMoneyParser;
use Omniship\Common\Address;
use Omniship\Exceptions\InvalidRequestException;
use Omniship\Exceptions\RuntimeException;
use Omniship\Helper\Helper;
use Omniship\Http\Client;
use Omniship\Common\ItemBag;
use Omniship\Interfaces\RequestInterface;
use Omniship\Interfaces\ResponseInterface;
use Omniship\Traits\Exceptions;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Abstract Request
 *
 * This abstract class implements RequestInterface and defines a basic
 * set of functions that all Omniship Requests are intended to include.
 *
 * Requests of this class are usually created using the createRequest
 * function of the gateway and then actioned using methods within this
 * class or a class that extends this class.
 *
 * Example -- creating a request:
 *
 * <code>
 *   class MyRequest extends \Omniship\Message\AbstractRequest {};
 *
 *   class MyGateway extends \Omniship\Common\AbstractGateway {
 *     function myRequest($parameters) {
 *       $this->createRequest('MyRequest', $parameters);
 *     }
 *   }
 *
 *   // Create the gateway object
 *   $gw = Omniship::create('MyGateway');
 *
 *   // Create the request object
 *   $myRequest = $gw->myRequest($someParameters);
 * </code>
 *
 * Example -- validating and sending a request:
 *
 * <code>
 *   try {
 *     $myRequest->validate();
 *     $myResponse = $myRequest->send();
 *   } catch (InvalidRequestException $e) {
 *     print "Something went wrong: " . $e->getMessage() . "\n";
 *   }
 *   // now do something with the $myResponse object, test for success, etc.
 * </code>
 *
 * @see RequestInterface
 * @see AbstractResponse
 */
abstract class AbstractRequest implements RequestInterface
{

    use Exceptions;

    const INVALID_ARGUMENTS = [
        '20001' => 'Invalid arguments for method Omniship\Message\AbstractRequest::setReceiverAddress',
        '20002' => 'Invalid arguments for method Omniship\Message\AbstractRequest::setSenderAddress',
    ];

    /**
     * The request parameters
     *
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;
    /**
     * The request client.
     *
     * @var Client
     */
    protected $httpClient;
    /**
     * The HTTP request object.
     *
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $httpRequest;
    /**
     * An associated ResponseInterface.
     *
     * @var ResponseInterface
     */
    protected $response;
    /**
     * @var ISOCurrencies
     */
    protected $currencies;
    /**
     * @var bool
     */
    protected $zeroAmountAllowed = true;
    /**
     * @var bool
     */
    protected $negativeAmountAllowed = false;
    /**
     * Create a new Request
     *
     * @param Client $httpClient  A HTTP client to make API calls with
     * @param HttpRequest     $httpRequest A Symfony HTTP request object
     */
    public function __construct(Client $httpClient, HttpRequest $httpRequest)
    {
        $this->httpClient = $httpClient;
        $this->httpRequest = $httpRequest;
        $this->initialize();
    }
    /**
     * Initialize the object with parameters.
     *
     * If any unknown parameters passed, they will be ignored.
     *
     * @param array $parameters An associative array of parameters
     *
     * @return $this
     * @throws RuntimeException
     */
    public function initialize(array $parameters = array())
    {
        if (null !== $this->response) {
            throw new RuntimeException('Request cannot be modified after it has been sent!');
        }
        $this->parameters = new ParameterBag;
        Helper::initialize($this, $parameters);
        return $this;
    }
    /**
     * Get all parameters as an associative array.
     *
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }
    /**
     * Get a single parameter.
     *
     * @param string $key The parameter key
     * @return mixed
     */
    protected function getParameter($key)
    {
        return $this->parameters->get($key);
    }
    /**
     * Set a single parameter
     *
     * @param string $key The parameter key
     * @param mixed $value The value to set
     * @return AbstractRequest Provides a fluent interface
     * @throws RuntimeException if a request parameter is modified after the request has been sent.
     */
    protected function setParameter($key, $value)
    {
        if (null !== $this->response) {
            throw new RuntimeException('Request cannot be modified after it has been sent!');
        }
        $this->parameters->set($key, $value);
        return $this;
    }
    /**
     * Gets the test mode of the request from the gateway.
     *
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }
    /**
     * Sets the test mode of the request.
     *
     * @param boolean $value True for test mode on.
     * @return AbstractRequest
     */
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }
    /**
     * Validate the request.
     *
     * This method is called internally by gateways to avoid wasting time with an API call
     * when the request is clearly invalid.
     *
     * @param string ... a variable length list of required parameters
     * @throws InvalidRequestException
     */
    public function validate()
    {
        foreach (func_get_args() as $key) {
            $value = $this->parameters->get($key);
            if (! isset($value)) {
                throw new InvalidRequestException("The $key parameter is required");
            }
        }
    }
    /**
     * Get the card token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }
    /**
     * Sets the card token.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }
    /**
     * @return ISOCurrencies
     */
    protected function getCurrencies()
    {
        if ($this->currencies === null) {
            $this->currencies = new ISOCurrencies();
        }
        return $this->currencies;
    }
    /**
     * @return null|Money
     * @throws InvalidRequestException
     */
    public function getMoney()
    {
        $amount = $this->getParameter('amount');
        if ($amount instanceof Money) {
            return $amount;
        }
        if ($amount !== null) {
            $moneyParser = new DecimalMoneyParser($this->getCurrencies());
            $currencyCode = $this->getCurrency() ?: 'USD';
            $currency = new Currency($currencyCode);
            $number = Number::fromString($amount);
            // Check for rounding that may occur if too many significant decimal digits are supplied.
            $decimal_count = strlen($number->getFractionalPart());
            $subunit = $this->getCurrencies()->subunitFor($currency);
            if ($decimal_count > $subunit) {
                throw new InvalidRequestException('Amount precision is too high for currency.');
            }
            $money = $moneyParser->parse((string) $number, $currency->getCode());
            // Check for a negative amount.
            if (!$this->negativeAmountAllowed && $money->isNegative()) {
                throw new InvalidRequestException('A negative amount is not allowed.');
            }
            // Check for a zero amount.
            if (!$this->zeroAmountAllowed && $money->isZero()) {
                throw new InvalidRequestException('A zero amount is not allowed.');
            }
            return $money;
        }
        return null;
    }
    /**
     * Validates and returns the formatted amount.
     *
     * @throws InvalidRequestException on any validation failure.
     * @return string The amount formatted to the correct number of decimal places for the selected currency.
     */
    public function getAmount()
    {
        $money = $this->getMoney();
        if ($money !== null) {
            $moneyFormatter = new DecimalMoneyFormatter($this->getCurrencies());
            return $moneyFormatter->format($money);
        }
        return '';
    }
    /**
     * Sets the payment amount.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setAmount($value)
    {
        return $this->setParameter('amount', $value);
    }
    /**
     * Get the payment amount as an integer.
     *
     * @return integer
     */
    public function getAmountInteger()
    {
        $money = $this->getMoney();
        if ($money !== null) {
            return $money->getAmount();
        }
        return 0;
    }
    /**
     * Get the payment currency code.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }
    /**
     * Sets the payment currency code.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setCurrency($value)
    {
        if ($value !== null) {
            $value = strtoupper($value);
        }
        return $this->setParameter('currency', $value);
    }
    /**
     * Get the payment currency number.
     *
     * @return string|null
     */
    public function getCurrencyNumeric()
    {
        if (! $this->getCurrency()) {
            return null;
        }
        $currency = new Currency($this->getCurrency());
        if ($this->getCurrencies()->contains($currency)) {
            return (string) $this->getCurrencies()->numericCodeFor($currency);
        }
        return null;
    }
    /**
     * Get the request description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getParameter('description');
    }
    /**
     * Sets the request description.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }
    /**
     * @return string
     */
    public function getWeightUnit()
    {
        return $this->getParameter('weight_unit');
    }
    /**
     * @param  $weight_unit
     * @return $this
     */
    public function setWeightUnit($weight_unit)
    {
        return $this->setParameter('weight_unit', $weight_unit);
    }
    /**
     * @return string
     */
    public function getDimensionUnit()
    {
        return $this->getParameter('dimension_unit');
    }
    /**
     * @param  $dimension_unit
     * @return $this
     */
    public function setDimensionUnit($dimension_unit)
    {
        return $this->setParameter('dimension_unit', $dimension_unit);
    }
    /**
     * Get the transaction ID.
     *
     * The transaction ID is the identifier generated by the merchant website.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getParameter('transactionId');
    }
    /**
     * Sets the transaction ID.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setTransactionId($value)
    {
        return $this->setParameter('transactionId', $value);
    }
    /**
     * Get the transaction reference.
     *
     * The transaction reference is the identifier generated by the remote
     * payment gateway.
     *
     * @return string
     */
    public function getTransactionReference()
    {
        return $this->getParameter('transactionReference');
    }
    /**
     * Sets the transaction reference.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setTransactionReference($value)
    {
        return $this->setParameter('transactionReference', $value);
    }
    /**
     * A list of items in this order
     *
     * @return ItemBag|null A bag containing items in this order
     */
    public function getItems()
    {
        return $this->getParameter('items');
    }
    /**
     * Set the items in this order
     *
     * @param ItemBag|array $items An array of items in this order
     * @return AbstractRequest
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new ItemBag($items);
        }
        return $this->setParameter('items', $items);
    }
    /**
     * Get the client IP address.
     *
     * @return string
     */
    public function getClientIp()
    {
        return $this->getParameter('clientIp');
    }
    /**
     * Sets the client IP address.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setClientIp($value)
    {
        return $this->setParameter('clientIp', $value);
    }
    /**
     * Get the request return URL.
     *
     * @return string
     */
    public function getReturnUrl()
    {
        return $this->getParameter('returnUrl');
    }
    /**
     * Sets the request return URL.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setReturnUrl($value)
    {
        return $this->setParameter('returnUrl', $value);
    }
    /**
     * Get the request cancel URL.
     *
     * @return string
     */
    public function getCancelUrl()
    {
        return $this->getParameter('cancelUrl');
    }
    /**
     * Sets the request cancel URL.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setCancelUrl($value)
    {
        return $this->setParameter('cancelUrl', $value);
    }
    /**
     * Get the request notify URL.
     *
     * @return string
     */
    public function getNotifyUrl()
    {
        return $this->getParameter('notifyUrl');
    }
    /**
     * Sets the request notify URL.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setNotifyUrl($value)
    {
        return $this->setParameter('notifyUrl', $value);
    }
    /**
     * Get the payment issuer.
     *
     * This field is used by some European gateways, and normally represents
     * the bank where an account is held (separate from the card brand).
     *
     * @return string
     */
    public function getIssuer()
    {
        return $this->getParameter('issuer');
    }
    /**
     * Set the payment issuer.
     *
     * This field is used by some European gateways, and normally represents
     * the bank where an account is held (separate from the card brand).
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setIssuer($value)
    {
        return $this->setParameter('issuer', $value);
    }
    /**
     * Get the payment issuer.
     *
     * This field is used by some European gateways, which support
     * multiple payment providers with a single API.
     *
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('paymentMethod');
    }
    /**
     * Set the payment method.
     *
     * This field is used by some European gateways, which support
     * multiple payment providers with a single API.
     *
     * @param string $value
     * @return AbstractRequest Provides a fluent interface
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('paymentMethod', $value);
    }
    /**
     * @return Address
     */
    public function getReceiverAddress()
    {
        return $this->getParameter('receiver_address');
    }
    /**
     * @param  Address|array $address
     * @return $this
     */
    public function setReceiverAddress($address)
    {
        if(!($address instanceof Address)) {
            $address = new Address($address);
        }
        if ($address->isEmpty()) {
            $this->invalidArguments('20001');
        }
        return $this->setParameter('receiver_address', $address);
    }
    /**
     * @return Address
     */
    public function getSenderAddress()
    {
        return $this->getParameter('sender_address');
    }
    /**
     * @param  Address|array $address
     * @return $this
     */
    public function setSenderAddress($address)
    {
        if(!($address instanceof Address)) {
            $address = new Address($address);
        }
        if ($address->isEmpty()) {
            $this->invalidArguments('20002');
        }
        return $this->setParameter('sender_address', $address);
    }
    /**
     * Send the request
     *
     * @return ResponseInterface
     */
    public function send()
    {
        $data = $this->getData();
        return $this->sendData($data);
    }
    /**
     * Get the associated Response.
     *
     * @return ResponseInterface
     */
    public function getResponse()
    {
        if (null === $this->response) {
            throw new RuntimeException('You must call send() before accessing the Response!');
        }
        return $this->response;
    }
}
