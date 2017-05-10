<?php
/**
 * Base payment gateway class
 */
namespace Omniship\Common;

use Omniship\Common\Http\Client;
use Omniship\Common\Message\RequestInterface;
use Omniship\Helper\Helper;
use Omniship\Interfaces\GatewayInterface;
use Omniship\Traits\Parameters;
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
    
    use Parameters;
    
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
     * Create and initialize a request object
     *
     * This function is usually used to create objects of type
     * Omniship\Common\Message\AbstractRequest (or a non-abstract subclass of it)
     * and initialise them with using existing parameters from this gateway.
     *
     * Example:
     *
     * <code>
     *   class MyRequest extends \Omniship\Common\Message\AbstractRequest {};
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
     * @see \Omniship\Common\Message\AbstractRequest
     * @param string $class The request class name
     * @param array $parameters
     * @return \Omniship\Common\Message\AbstractRequest
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
