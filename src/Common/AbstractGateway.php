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
use Omniship\Traits\Parameters;
use Omniship\Traits\ParametersData;
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
 * </code>
 *
 * For further code examples see the *omniship-example* repository on github.
 *
 * @see GatewayInterface
 */
abstract class AbstractGateway implements GatewayInterface
{

    use Exceptions, ParametersData, Parameters {
        Parameters::__construct AS parametersConstruct;
    }
    
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
        $this->parametersConstruct();
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
     * Supports getQuotes
     *
     * @return boolean True if this gateway supports the getQuotes() method
     */
    public function supportsGetQuotes()
    {
        return method_exists($this, 'getQuotes');
    }
    /**
     * Supports getServices
     *
     * @return boolean True if this gateway supports the getServices() method
     */
    public function supportsGetServices()
    {
        return method_exists($this, 'getServices');
    }
    /**
     * Supports addressValidation
     *
     * @return boolean True if this gateway supports the validateAddress() method
     */
    public function supportsValidateAddress()
    {
        return method_exists($this, 'validateAddress');
    }
    /**
     * Supports validateCredentials
     *
     * @return boolean True if this gateway supports the validateCredentials() method
     */
    public function supportsValidateCredentials()
    {
        return method_exists($this, 'validateCredentials');
    }
    /**
     * Supports validatePostCode
     *
     * @return boolean True if this gateway supports the validatePostCode() method
     */
    public function supportsValidatePostCode()
    {
        return method_exists($this, 'validatePostCode');
    }
    /**
     * Supports createBillOfLading
     *
     * @return boolean True if this gateway supports the createBillOfLading() method
     */
    public function supportsCreateBillOfLading()
    {
        return method_exists($this, 'createBillOfLading');
    }
    /**
     * Supports getPdf
     *
     * @return boolean True if this gateway supports the getPdf() method
     */
    public function supportsGetPdf()
    {
        return method_exists($this, 'getPdf');
    }
    /**
     * Supports cancelBillOfLading
     *
     * @return boolean True if this gateway supports the cancelBillOfLading() method
     */
    public function supportsCancelBillOfLading()
    {
        return method_exists($this, 'cancelBillOfLading');
    }
    /**
     * Supports deleteBillOfLading
     *
     * @return boolean True if this gateway supports the deleteBillOfLading() method
     */
    public function supportsDeleteBillOfLading()
    {
        return method_exists($this, 'deleteBillOfLading');
    }
    /**
     * Supports trackingParcel
     *
     * @return boolean True if this gateway supports the trackingParcel() method
     */
    public function supportsTrackingParcel()
    {
        return method_exists($this, 'trackingParcel');
    }
    /**
     * Supports trackingParcels
     *
     * @return boolean True if this gateway supports the trackingParcels() method
     */
    public function supportsTrackingParcels()
    {
        return method_exists($this, 'trackingParcels');
    }
    /**
     * Supports requestCourier
     *
     * @return boolean True if this gateway supports the requestCourier() method
     */
    public function supportsRequestCourier()
    {
        return method_exists($this, 'requestCourier');
    }
    /**
     * Supports codPayment
     *
     * @return boolean True if this gateway supports the codPayment() method
     */
    public function supportsCodPayment()
    {
        return method_exists($this, 'codPayment');
    }
    /**
     * Supports codPayment
     *
     * @return boolean True if this gateway supports the codPayment() method
     */
    public function supportsCodPayments()
    {
        return method_exists($this, 'codPayments');
    }
    /**
     * Supports getClient
     *
     * @return boolean True if this gateway supports the getClient() method
     */
    public function supportsGetClient()
    {
        return method_exists($this, 'getClient');
    }
    /**
     * Supports Cash On Delivery
     *
     * @return boolean True if this gateway supports the Cash On Delivery
     */
    public function supportsCashOnDelivery()
    {
        return false;
    }
    /**
     * Supports Insurance
     *
     * @return boolean True if this gateway supports the Insurance
     */
    public function supportsInsurance()
    {
        return false;
    }
    /**
     * Supports Declared
     *
     * @return boolean True if this gateway supports the Declared
     */
    public function supportsDeclared()
    {
        return false;
    }
    /**
     * Supports supportsTrackingUrl
     *
     * @return boolean True if this gateway supports trackingUrl
     */
    public function supportsTrackingUrl()
    {
        return method_exists($this, 'trackingUrl');
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
