<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 17:51 ч.
 */

namespace Omniship\Exceptions;

use Omniship\Interfaces\OmnishipException;

class InvalidResponseException extends \Exception implements OmnishipException
{
    public function __construct($message = "Invalid response from shipping gateway", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}