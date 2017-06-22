<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 11:20 ч.
 */

namespace Omniship\Exceptions;

use Omniship\Interfaces\OmnishipException;

class InvalidArgumentException extends \InvalidArgumentException implements OmnishipException
{
    /**
     * InvalidArgumentException constructor.
     * @param string $message
     * @param int $code
     * @param null $previous
     */
    public function __construct($message = "", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
        array_shift($backtrace);
        $first = array_shift($backtrace);
        if (!empty($first['file'])) {
            $this->file = $first['file'];
        }
        if (!empty($first['line'])) {
            $this->line = $first['line'];
        }
    }
}
