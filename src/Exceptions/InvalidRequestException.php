<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 13:32 ч.
 */

namespace Omniship\Exceptions;

use Omniship\Interfaces\OmnishipException;

/**
 * Invalid Request Exception
 *
 * Thrown when a request is invalid or missing required fields.
 */
class InvalidRequestException extends \Exception implements OmnishipException
{
}
