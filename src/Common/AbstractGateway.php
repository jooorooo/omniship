<?php
/**
 * Base payment gateway class
 */
namespace Omniship\Common;

use Omniship\Http\Client;
use Omniship\Interfaces\RequestInterface;
use Omniship\Helper\Helper;
use Omniship\Interfaces\GatewayInterface;
use Omniship\Traits\Exceptions;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request as HttpRequest;

/**
 * Base payment gateway class
 *
 * This abstract class should be extended by all payment gateways
 * throughout the Omniship system.  It enforces implementation of
 * the GatewayInterface interface and defines various common attibutes
 * and methods that all gateways should have.
 *
 * Example:
 *
 * <code>
 *   // Initialise the gateway
 *   $gateway->initialize(...);
 *
 *   // Get the gateway parameters.
 *   $parameters = $gateway->getParameters();
 *
 *   // Create a credit card object
 *   $card = new CreditCard(...);
 *
 *   // Do an authorisation transaction on the gateway
 *   if ($gateway->supportsAuthorize()) {
 *       $gateway->authorize(...);
 *   } else {
 *       throw new \Exception('Gateway does not support authorize()');
 *   }
 * </code>
 *
 * For further code examples see the *omniship-example* repository on github.
 *
 * @see GatewayInterface
 */
abstract class AbstractGateway implements GatewayInterface
{

    use Exceptions;

    const INVALID_ARGUMENTS = [
        '20001' => 'Invalid arguments for method Omniship\Common\AbstractGateway::setReceiverAddress',
        '20002' => 'Invalid arguments for method Omniship\Common\AbstractGateway::setSenderAddress',
    ];

    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;
    
    /**
     * @var Client
     */
    protected $httpClient;
    /**
     * @var \Symfony\Component\HttpFoundation\Request
     */
    protected $httpRequest;
    /**
     * Create a new gateway instance
     *
     * @param Client          $httpClient  A HTTP client to make API calls with
     * @param HttpRequest     $httpRequest A Symfony HTTP request object
     */
    public function __construct(Client $httpClient = null, HttpRequest $httpRequest = null)
    {
        $this->httpClient = $httpClient ?: $this->getDefaultHttpClient();
        $this->httpRequest = $httpRequest ?: $this->getDefaultHttpRequest();
        $this->initialize();
    }
    /**
     * Get the short name of the Gateway
     *
     * @return string
     */
    public function getShortName()
    {
        return Helper::getGatewayShortName(get_class($this));
    }
    /**
     * Initialize this gateway with default parameters
     *
     * @param  array $parameters
     * @return $this
     */
    public function initialize(array $parameters = array())
    {
        $this->parameters = new ParameterBag;
        // set default parameters
        foreach ($this->getDefaultParameters() as $key => $value) {
            if (is_array($value)) {
                $this->parameters->set($key, reset($value));
            } else {
                $this->parameters->set($key, $value);
            }
        }
        Helper::initialize($this, $parameters);
        return $this;
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);
        return $this;
    }
    /**
     * @return array
     */
    public function getDefaultParameters()
    {
        return array();
    }
    /**
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }
    /**
     * @param  boolean $value
     * @return $this
     */
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }
    /**
     * @return string
     */
    public function getCurrency()
    {
        return strtoupper($this->getParameter('currency'));
    }
    /**
     * @param  string $value
     * @return $this
     */
    public function setCurrency($value)
    {
        return $this->setParameter('currency', $value);
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
     * @return ItemBag
     */
    public function getItems()
    {
        return $this->getParameter('items');
    }
    /**
     * @param  ItemBag $items
     * @return $this
     */
    public function setItems(ItemBag $items)
    {
        return $this->setParameter('items', $items);
    }
    /**
     * Supports Authorize
     *
     * @return boolean True if this gateway supports the authorize() method
     */
    public function supportsAuthorize()
    {
        return method_exists($this, 'authorize');
    }
    /**
     * Supports Complete Authorize
     *
     * @return boolean True if this gateway supports the completeAuthorize() method
     */
    public function supportsCompleteAuthorize()
    {
        return method_exists($this, 'completeAuthorize');
    }
    /**
     * Supports GetQuote
     *
     * @return boolean True if this gateway supports the getQuote() method
     */
    public function supportsGetQuote()
    {
        return method_exists($this, 'getQuote');
    }
    /**
     * Create and initialize a request object
     *
     * This function is usually used to create objects of type
     * Omniship\Message\AbstractRequest (or a non-abstract subclass of it)
     * and initialise them with using existing parameters from this gateway.
     *
     * Example:
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
     * @see \Omniship\Message\AbstractRequest
     * @param string $class The request class name
     * @param array $parameters
     * @return \Omniship\Message\AbstractRequest
     */
    protected function createRequest($class, array $parameters)
    {
        /** @var $obj RequestInterface */
        $obj = new $class($this->httpClient, $this->httpRequest);
        return $obj->initialize(array_replace($this->getParameters(), $parameters));
    }
    /**
     * Get the global default HTTP client.
     *
     * @return Client
     */
    protected function getDefaultHttpClient()
    {
        return new Client();
    }
    /**
     * Get the global default HTTP request.
     *
     * @return HttpRequest
     */
    protected function getDefaultHttpRequest()
    {
        return HttpRequest::createFromGlobals();
    }
}
