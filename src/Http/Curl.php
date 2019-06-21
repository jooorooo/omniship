<?php

namespace Omniship\Http;

class Curl
{
    /**
     * Contains the target URL
     *
     * @var string
     */
    protected $target;

    /**
     * Contains the target host
     *
     * @var string
     */
    protected $host;

    /**
     * Contains the target port
     *
     * @var integer
     */
    protected $port;

    /**
     * Contains the target path
     *
     * @var string
     */
    protected $path;

    /**
     * Contains the target schema
     *
     * @var string
     */
    protected $schema;

    /**
     * Contains the http method (GET or POST)
     *
     * @var string
     */
    protected $method;

    /**
     * Contains the parameters for request
     *
     * @var array
     */
    protected $params;

    /**
     * Contains the body for request
     *
     * @var string
     */
    protected $set_xml;

    /**
     * Contains the cookies for request
     *
     * @var array
     */
    protected $cookies;

    /**
     * Contains the cookies retrieved from response
     *
     * @var array
     */
    protected $_cookies;

    /**
     * Number of seconds to timeout
     *
     * @var integer
     */
    protected $timeout;

    /**
     * Whether to use cURL or not
     *
     * @var boolean
     */
    protected $useCurl;

    /**
     * Contains the referrer URL
     *
     * @var string
     */
    protected $referrer;

    /**
     * Contains the User agent string
     *
     * @var string
     */
    protected $userAgent;

    /**
     * Contains the cookie path (to be used with cURL)
     *
     * @var string
     */
    protected $cookiePath;

    /**
     * Whether to use cookie at all
     *
     * @var boolean
     */
    protected $useCookie;

    /**
     * Whether to store cookie for subsequent requests
     *
     * @var boolean
     */
    protected $saveCookie;

    /**
     * Contains the Username (for authentication)
     *
     * @var string
     */
    protected $username;

    /**
     * Contains the Password (for authentication)
     *
     * @var string
     */
    protected $password;

    /**
     * Contains the fetched web source
     *
     * @var string
     */
    protected $result;

    /**
     * Contains the last headers
     *
     * @var string
     */
    protected $headers;

    /**
     * Contains the last call's http status code
     *
     * @var string
     */
    protected $status;

    /**
     * Whether to follow http redirect or not
     *
     * @var boolean
     */
    protected $redirect;

    /**
     * The maximum number of redirect to follow
     *
     * @var integer
     */
    protected $maxRedirect;

    /**
     * The current number of redirects
     *
     * @var integer
     */
    protected $curRedirect;

    /**
     * Contains any error occurred
     *
     * @var string
     */
    protected $error;

    /**
     * Store the next token
     *
     * @var string
     */
    protected $nextToken;

    /**
     * Whether to keep debug messages
     *
     * @var boolean
     */
    protected $debug;

    /**
     * Set request headers
     *
     * @var array
     */
    protected $set_headers = [];

    /**
     * Stores the debug messages
     *
     * @var array
     * @todo will keep debug messages
     */
    protected $debugMsg;

    /**
     * @var null|string
     */
    protected $post_type; //null,json

    /**
     * Constructor for initializing the class with default values.
     */
    public function __construct()
    {
        $this->clear();
    }

    /**
     * @param $host
     * @param int $timeout
     * @param int $redirect
     * @return bool|string
     */
    public static function pingHostOnline($host, $timeout = 30, $redirect = 1)
    {
        $context = stream_context_create([
            'http' => [
                'method' => "GET",
                'max_redirects' => '3',
                'header' => "Accept-language: " . setting('language') . "\r\n" .
                    "User-Agent:    Mozilla/5.0 (Windows; U; Windows NT 6.0; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6\r\n"
            ]
        ]);
        try {
            $handle = fopen($host, "r", false, $context);
        } catch (\Exception $e) {
            return $e->getMessage();
        }
        if (!$handle) {
            return 'Failed to open stream: HTTP request failed!';
        }
        stream_set_timeout($handle, $timeout);
        $stream = stream_get_meta_data($handle);
        fclose($handle);
        if (!empty($stream) && !empty($meta = $stream['wrapper_data'])) {
            $instance = new static();
            foreach ($meta AS $header) {
                if (preg_match($match = "~^http/[0-9]+\\.[0-9]+[ \t]+([0-9]+)[ \t]*(.*)\$~i", $header, $matches)) {
                    $instance->status = $matches[1];
                    continue;
                }

//				 Get name and value
                $headerName = strtolower($instance->_tokenize($header, ':'));
                $headerValue = trim(chop($instance->_tokenize("\r\n")));

                // If its already there, then add as an array. Otherwise, just keep
                // there
                if (isset ($instance->headers [$headerName])) {
                    if (gettype($instance->headers [$headerName]) == "string") {
                        $instance->headers [$headerName] = array(
                            $instance->headers [$headerName]
                        );
                    }

                    $instance->headers [$headerName] [] = $headerValue;
                } else {
                    $instance->headers [$headerName] = $headerValue;
                }
            }
            if (in_array($instance->status, [301, 302]) && !empty($instance->headers['location']) && $redirect <= $instance->maxRedirect) {
                return static::pingHostOnline(is_array($instance->headers['location']) ? array_first($instance->headers['location']) : $instance->headers['location'], $timeout, $redirect + 1);
            }
            return $instance->status == 200 ? true : 'Response status is: ' . $instance->status . '. Host' . $host;
        }
        return 'Undefined error!';
    }

    /**
     * Initialize preferences
     *
     * This function will take an associative array of config values and
     * will initialize the class variables using them.
     *
     * Example use:
     *
     * <pre>
     * $httpConfig['method'] = 'GET';
     * $httpConfig['target'] = 'http://www.somedomain.com/index.html';
     * $httpConfig['referrer'] = 'http://www.somedomain.com';
     * $httpConfig['user_agent'] = 'My Crawler';
     * $httpConfig['timeout'] = '30';
     * $httpConfig['params'] = array('var1' => 'testvalue', 'var2' =>
     * 'somevalue');
     *
     * $http = new Http();
     * $http->initialize($httpConfig);
     * </pre>
     *
     * @param array $config
     *            array Config values as associative array
     * @return void
     */
    public function initialize($config = array())
    {
        $this->clear();
        foreach ($config as $key => $val) {
            if (isset ($this->{$key})) {
                $method = 'set' . ucfirst(str_replace('_', '', $key));

                if (method_exists($this, $method)) {
                    $this->$method ($val);
                } else {
                    $this->{$key} = $val;
                }
            }
        }
    }

    /**
     * Clear Everything
     *
     * Clears all the properties of the class and sets the object to
     * the beginning state. Very handy if you are doing subsequent calls
     * with different data.
     *
     * @return void
     */
    public function clear()
    {
        // Set the request defaults
        $this->host = '';
        $this->port = 0;
        $this->path = '';
        $this->target = '';
        $this->method = 'GET';
        $this->schema = 'http';
        $this->params = array();
        $this->headers = array();
        $this->cookies = array();
        $this->_cookies = array();

        // Set the config details
        $this->debug = false;
        $this->error = '';
        $this->status = 0;
        $this->timeout = '-1';
        $this->referrer = '';
        $this->username = '';
        $this->password = '';
        $this->redirect = true;

        // Set the cookie and agent defaults
        $this->nextToken = '';
        $this->useCookie = true;
        $this->saveCookie = true;
        $this->maxRedirect = 3;
        $this->cookiePath = 'cookie.txt';
        $this->userAgent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.9';
        $this->post_type = null;
        $this->set_headers = [];
        $this->set_xml = null;
    }

    /**
     * Set target URL
     *
     * @param string URL of target resource
     * @return $this
     */
    public function setTarget($url)
    {
        $this->target = $url;
        return $this;
    }

    /**
     * Set header
     *
     * @param string
     * @return $this
     */
    public function setHeader($key, $value)
    {
        $this->set_headers[strtolower($key)] = $value;
        return $this;
    }

    /**
     * Set headers
     *
     * @param string
     * @return $this
     */
    public function setHeaders(array $headers)
    {
        foreach ($headers AS $header_key => $header_value) {
            $this->setHeader($header_key, $header_value);
        }
        return $this;
    }

    /**
     * Reset headers
     *
     * @return $this
     */
    public function resetHeaders()
    {
        $this->set_headers = [];
        return $this;
    }

    /**
     * @param string|null $post_type
     * @return $this
     */
    public function setPostType($post_type)
    {
        $this->post_type = $post_type;
        return $this;
    }

    /**
     * Set http method
     *
     * @param string $token
     * @return $this
     */
    public function setBearer($token)
    {
        $this->set_headers['authorization'] = 'Bearer ' . $token;
        return $this;
    }

    /**
     * Set http method
     *
     * @param string HTTP method to use (GET or POST)
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = in_array($method = strtolower($method), ['get', 'post']) ? $method : 'get';
        return $this;
    }

    /**
     * Set referrer URL
     *
     * @param string URL of referrer page
     * @return $this
     */
    public function setReferrer($referrer)
    {
        $this->referrer = $referrer;
        return $this;
    }

    /**
     * Set User agent string
     *
     * @param string Full user agent string
     * @return $this
     */
    public function setUseragent($agent)
    {
        $this->userAgent = $agent;
        return $this;
    }

    /**
     * Set timeout of execution
     *
     * @param integer Timeout delay in seconds
     * @return void
     */
    public function setTimeout(int $seconds)
    {
        if ($seconds > 0) {
            $this->timeout = $seconds;
        }
        return $this;
    }

    /**
     * Set cookie path (cURL only)
     *
     * @param string File location of cookiejar
     * @return $this
     */
    public function setCookiepath($path)
    {
        $this->cookiePath = $path;
        return $this;
    }

    /**
     * Set request parameters
     *
     * @param array All the parameters for GET or POST
     * @return $this
     */
    public function setParams(array $dataArray)
    {
        $this->params = array_merge($this->params, $dataArray);
        return $this;
    }

    /**
     * Set request parameters
     *
     * @param string xml
     * @return $this
     */
    public function setXml($xml)
    {
        $this->set_xml = $xml;
        return $this;
    }

    /**
     * Set basic http authentication realm
     *
     * @param string Username for authentication
     * @param string Password for authentication
     * @return $this
     */
    public function setAuth($username, $password)
    {
        if (!empty ($username) && !empty ($password)) {
            $this->username = $username;
            $this->password = $password;
        }
        return $this;
    }

    /**
     * Set maximum number of redirection to follow
     *
     * @param integer Maximum number of redirects
     * @return $this
     */
    public function setMaxredirect(int $value)
    {
        if ($value > 0) {
            $this->maxRedirect = $value;
        }
        return $this;
    }

    /**
     * Add request parameters
     *
     * @param string Name of the parameter
     * @param string Value of the parameter
     * @return $this
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;
        return $this;
    }

    /**
     * Add a cookie to the request
     *
     * @param string Name of cookie
     * @param string Value of cookie
     * @return $this
     */
    public function addCookie($name, $value)
    {
        $this->cookies [$name] = $value;
        return $this;
    }

    /**
     * Whether to use cookies or not
     *
     * @param boolean $value
     *
     * @return $this
     */
    public function useCookie($value = true)
    {
        $this->useCookie = (bool)$value;
        return $this;
    }

    /**
     * Whether to save persistent cookies in subsequent calls
     *
     * @param boolean $value
     *
     * @return $this
     */
    public function saveCookie($value = true)
    {
        $this->saveCookie = (bool)$value;
        return $this;
    }

    /**
     * Whether to follow HTTP redirects
     *
     * @param boolean $value
     *
     * @return $this
     */
    public function followRedirects($value = true)
    {
        $this->redirect = $value;
        return $this;
    }

    /**
     * Get execution result body
     *
     * @return string output of execution
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * Get execution result headers
     *
     * @return array last headers of execution
     */
    public function getHeaders()
    {
        return $this->headers;
    }

    /**
     * Get execution status code
     *
     * @return integer last http status code
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Get last execution error
     *
     * @return string last error message (if any)
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * Execute a HTTP request
     *
     * Executes the http fetch using all the set properties. Intellegently
     * switch to fsockopen if cURL is not present. And be smart to follow
     * redirects (if asked so).
     *
     * @param string $target
     *            string URL of the target page (optional)
     * @param string $referrer
     *            string URL of the referrer page (optional)
     * @param string $method
     *            string The http method (GET or POST) (optional)
     * @param array $data
     *            array Parameter array for GET or POST (optional)
     * @return string Response body of the target page
     */
    public function execute($target = null, $referrer = null, $method = null, $data = [])
    {
        // Populate the properties
        $this->target = $target ? $target : $this->target;
        $this->method = $method ? $method : $this->method;

        $this->referrer = ($referrer) ? $referrer : $this->referrer;

        // Add the new params
        if (is_array($data) && count($data) > 0) {
            $this->params = array_merge($this->params, $data);
        }

        // Process data, if presented
        if (is_array($this->params) && count($this->params) > 0) {
            $queryString = $this->_normaliseParameters(http_build_query($this->params));
        } elseif($this->set_xml) {
            $queryString = $this->set_xml;
        }

        // GET method configuration
        if ($this->method == 'get') {
            if (isset ($queryString)) {
                $this->target = $this->target . "?" . $queryString;
            }
        }

        // Parse target URL
        $urlParsed = @parse_url($this->target);

        // Handle SSL connection request
        if (@$urlParsed ['scheme'] == 'https') {
            $this->host = 'ssl://' . $urlParsed ['host'];
            $this->port = ($this->port != 0) ? $this->port : 443;
        } else {
            $this->host = @$urlParsed ['host'];
            $this->port = ($this->port != 0) ? $this->port : 80;
        }

        // Finalize the target path
        $this->path = (isset ($urlParsed ['path']) ? $urlParsed ['path'] : '/') . (isset ($urlParsed ['query']) ? '?' . $urlParsed ['query'] : '');
        $this->schema = @$urlParsed ['scheme'];

        // Pass the requred cookies
        $this->_passCookies();

        // Process cookies, if requested
        if (is_array($this->cookies) && count($this->cookies) > 0) {
            // Get a blank slate
            $tempString = array();

            // Convert cookiesa array into a query string (ie
            // animal=dog&sport=baseball)
            foreach ($this->cookies as $key => $value) {
                if (strlen(trim($value)) > 0) {
                    $tempString [] = $key . "=" . urlencode($value);
                }
            }

            $cookieString = join('&', $tempString);
        }

        // Initialize PHP cURL handle
        $ch = curl_init();

        // GET method configuration
        if ($this->method == 'get') {
            curl_setopt($ch, CURLOPT_HTTPGET, true);
            curl_setopt($ch, CURLOPT_POST, false);
        }            // POST method configuration
        else {
            if (isset ($queryString)) {
                if ($this->post_type == 'json') {
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string = json_encode($this->params));
                    $this->setHeaders([
                        'Content-Type' => 'application/json',
                        'Content-Length' => strlen($data_string)
                    ]);
                } else {
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $queryString);
                }
            }

            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPGET, false);
        }

        // Basic Authentication configuration
        if ($this->username && $this->password) {
            curl_setopt($ch, CURLOPT_USERPWD, $this->username . ':' . $this->password);
        }

        if ($http_headers = $this->compileHeaders()) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $http_headers);
        }

        // Custom cookie configuration
        if ($this->useCookie && isset ($cookieString)) {
            curl_setopt($ch, CURLOPT_COOKIE, $cookieString);
        }

        curl_setopt($ch, CURLOPT_HEADER, true); // No need of headers
        curl_setopt($ch, CURLOPT_NOBODY, false); // Return body

        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            curl_setopt($ch, CURLOPT_COOKIEJAR, $this->cookiePath); // Cookie
            // management.
        }
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->timeout); // Timeout
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->timeout); // Timeout

        curl_setopt($ch, CURLOPT_USERAGENT, $this->userAgent); // Webbot
        // name
        @curl_setopt($ch, CURLOPT_URL, $this->target); // Target
        // site
        curl_setopt($ch, CURLOPT_REFERER, $this->referrer); // Referer
        // value

        curl_setopt($ch, CURLOPT_VERBOSE, false); // Minimize logs
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // No certificate

        $fixRedirect = true;
        if (!ini_get('safe_mode') && !ini_get('open_basedir')) {
            $fixRedirect = false;
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, $this->redirect);
        }
        // Follow redirects
        curl_setopt($ch, CURLOPT_MAXREDIRS, $this->maxRedirect); // Limit
        // redirections
        // to four
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return in string

        // Get the target contents
        $content = curl_exec($ch);

        $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);

        $result = array();
        $result ['header'] = mb_substr($content, 0, $header_size, 'utf-8');
        $result ['body'] = mb_substr($content, $header_size, mb_strlen($content, 'utf-8'), 'utf-8');

        // Store the contents
        $this->result = $result ['body'];

        // Parse the headers
        $this->_parseHeaders($result ['header']);

        // Store the error (is any)
        $this->_setError(curl_error($ch));

        // Close PHP cURL handle
        curl_close($ch);

        if ($fixRedirect && $this->getStatus() == 301 && $this->curRedirect < $this->maxRedirect) {
            $headers = $this->getHeaders();
            if (isset($headers['location']) && $headers['location']) {
                $this->execute($headers['location']);
                $this->curRedirect++;
            }
        }

        // There it is! We have it!! Return to base !!!
        return $this->result;
    }

    protected function compileHeaders()
    {
        $headers = [];
        foreach ($this->set_headers AS $key => $value) {
            $headers[] = sprintf('%s: %s', $k, $v);
        }

        return $headers;
    }

    /**
     * @param $parameters
     * @return array|mixed
     */
    protected function _normaliseParameters($parameters)
    {
        if (is_array($parameters)) {
            $t = [];
            foreach ($parameters AS $k => $v) {
                $t[urldecode($k)] = $this->_normaliseParameters($v);
            }
            return $t;
        } else {
            return str_replace(['%7B', '%7D', '%24'], ['{', '}', '$'], $parameters);
        }
    }

    /**
     * Parse Headers (internal)
     *
     * Parse the response headers and store them for finding the resposne
     * status, redirection location, cookies, etc.
     *
     * @param
     *            string Raw header response
     * @return void
     * @access private
     */
    protected function _parseHeaders($responseHeader)
    {
        // Break up the headers
        $headers = explode("\r\n", $responseHeader);

        // Clear the header array
        $this->_clearHeaders();

        // Get resposne status
        if ($this->status == 0) {
            // Oooops !
            if (!preg_match($match = "~^http/[0-9]+\\.[0-9]+[ \t]+([0-9]+)[ \t]*(.*)\$~i", $headers [0], $matches)) {
                $this->_setError('Unexpected HTTP response status');
                return;
            }

            // Gotcha!
            $this->status = $matches [1];
            array_shift($headers);
        }

        // Prepare all the other headers
        foreach ($headers as $header) {
            if (preg_match($match = "~^http/[0-9]+\\.[0-9]+[ \t]+([0-9]+)[ \t]*(.*)\$~i", $header, $matches)) {
                $this->status = $matches [1];
                continue;
            }

            // Get name and value
            $headerName = strtolower($this->_tokenize($header, ':'));
            $headerValue = trim(chop($this->_tokenize("\r\n")));

            // If its already there, then add as an array. Otherwise, just keep
            // there
            if (isset ($this->headers [$headerName])) {
                if (gettype($this->headers [$headerName]) == "string") {
                    $this->headers [$headerName] = array(
                        $this->headers [$headerName]
                    );
                }

                $this->headers [$headerName] [] = $headerValue;
            } else {
                $this->headers [$headerName] = $headerValue;
            }
        }

        // Save cookies if asked
        if ($this->saveCookie && isset ($this->headers ['set-cookie'])) {
            $this->_parseCookie();
        }
    }

    /**
     * Clear the headers array (internal)
     *
     * @return void
     * @access private
     */
    protected function _clearHeaders()
    {
        $this->headers = array();
    }

    /**
     * Parse Cookies (internal)
     *
     * Parse the set-cookie headers from response and add them for inclusion.
     *
     * @return void
     * @access private
     */
    protected function _parseCookie()
    {
        // Get the cookie header as array
        if (gettype($this->headers ['set-cookie']) == "array") {
            $cookieHeaders = $this->headers ['set-cookie'];
        } else {
            $cookieHeaders = array(
                $this->headers ['set-cookie']
            );
        }

        // Loop through the cookies
        for ($cookie = 0; $cookie < count($cookieHeaders); $cookie++) {
            $cookieName = trim($this->_tokenize($cookieHeaders [$cookie], "="));
            $cookieValue = $this->_tokenize(";");

            $domain = @parse_url($this->target, PHP_URL_HOST);
            $secure = '0';

            $path = "/";
            $expires = "";

            while (($name = trim(urldecode($this->_tokenize("=")))) != "") {
                $value = urldecode($this->_tokenize(";"));

                switch ($name) {
                    case "path" :
                        $path = $value;
                        break;
                    case "domain" :
                        $domain = $value;
                        break;
                    case "secure" :
                        $secure = ($value != '') ? '1' : '0';
                        break;
                }
            }

            $this->_setCookie($cookieName, $cookieValue, $expires, $path, $domain, $secure);
        }
    }

    /**
     * Set cookie (internal)
     *
     * Populate the internal _cookies array for future inclusion in
     * subsequent requests. This actually validates and then populates
     * the object properties with a dimensional entry for cookie.
     *
     * @param string $name
     *            string Cookie name
     * @param string $value
     *            string Cookie value
     * @param string $expires
     *            string Cookie expire date
     * @param string $path
     *            string Cookie path
     * @param string $domain
     *            string Cookie domain
     * @param integer $secure
     *            integer Cookie security (0 = non-secure, 1 = secure)
     * @return boolean|string
     * @access private
     */
    protected function _setCookie($name, $value, $expires = "", $path = "/", $domain = "", $secure = 0)
    {
        if (strlen($name) == 0) {
            return ($this->_setError("No valid cookie name was specified."));
        }

        if (strlen($path) == 0 || strcmp($path [0], "/")) {
            return ($this->_setError("$path is not a valid path for setting cookie $name."));
        }

        if ($domain == "" || !strpos($domain, ".", $domain [0] == "." ? 1 : 0)) {
            return ($this->_setError("$domain is not a valid domain for setting cookie $name."));
        }

        $domain = strtolower($domain);

        if (!strcmp($domain [0], ".")) {
            $domain = substr($domain, 1);
        }

        $name = $this->_encodeCookie($name, true);
        $value = $this->_encodeCookie($value, false);

        $secure = intval($secure);

        $this->_cookies [] = array(
            "name" => $name,
            "value" => $value,
            "domain" => $domain,
            "path" => $path,
            "expires" => $expires,
            "secure" => $secure
        );
        return true;
    }

    /**
     * Encode cookie name/value (internal)
     *
     * @param
     *            string Value of cookie to encode
     * @param
     *            string Name of cookie to encode
     * @return string encoded string
     * @access private
     */
    protected function _encodeCookie($value, $name)
    {
        return ($name ? str_replace("=", "%25", $value) : str_replace(";", "%3B", $value));
    }

    /**
     * Pass Cookies (internal)
     *
     * Get the cookies which are valid for the current request. Checks
     * domain and path to decide the return.
     *
     * @return void
     * @access private
     */
    protected function _passCookies()
    {
        if (is_array($this->_cookies) && count($this->_cookies) > 0) {
            $urlParsed = parse_url($this->target);
            $tempCookies = array();

            foreach ($this->_cookies as $cookie) {
                if ($this->_domainMatch($urlParsed ['host'], $cookie ['domain']) && (0 === strpos($urlParsed ['path'], $cookie ['path'])) && (empty ($cookie ['secure']) || $urlParsed ['protocol'] == 'https')) {
                    $tempCookies [$cookie ['name']] [strlen($cookie ['path'])] = $cookie ['value'];
                }
            }

            // cookies with longer paths go first
            foreach ($tempCookies as $name => $values) {
                krsort($values);
                foreach ($values as $value) {
                    $this->addCookie($name, $value);
                }
            }
        }
    }

    /**
     * Checks if cookie domain matches a request host (internal)
     *
     * Cookie domain can begin with a dot, it also must contain at least
     * two dots.
     *
     * @param
     *            string Request host
     * @param
     *            string Cookie domain
     * @return bool Match success
     * @access private
     */
    protected function _domainMatch($requestHost, $cookieDomain)
    {
        if ('.' != $cookieDomain{0}) {
            return $requestHost == $cookieDomain;
        } elseif (substr_count($cookieDomain, '.') < 2) {
            return false;
        } else {
            return substr('.' . $requestHost, -strlen($cookieDomain)) == $cookieDomain;
        }
    }

    /**
     * Tokenize String (internal)
     *
     * Tokenize string for various internal usage. Omit the second parameter
     * to tokenize the previous string that was provided in the prior call to
     * the function.
     *
     * @param string $string
     *            string The string to tokenize
     * @param string $separator
     *            string The seperator to use
     * @return string Tokenized string
     * @access private
     */
    protected function _tokenize($string, $separator = '')
    {
        if (!strcmp($separator, '')) {
            $separator = $string;
            $string = $this->nextToken;
        }

        for ($character = 0; $character < strlen($separator); $character++) {
            if (gettype($position = strpos($string, $separator [$character])) == "integer") {
                $found = (isset ($found) ? min($found, $position) : $position);
            }
        }

        if (isset ($found)) {
            $this->nextToken = substr($string, $found + 1);
            return (substr($string, 0, $found));
        } else {
            $this->nextToken = '';
            return ($string);
        }
    }

    /**
     * Set error message (internal)
     *
     * @param
     *            string Error message
     * @return null|string Error message
     * @access private
     */
    protected function _setError($error)
    {
        if ($error != '') {
            $this->error = $error;
            return $error;
        }
        return null;
    }
}
