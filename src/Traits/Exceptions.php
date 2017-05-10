<?php

namespace Omniship\Traits;


use Omniship\Exceptions\InvalidArgumentException;

trait Exceptions
{

    /**
     * @param $code
     * @throws InvalidArgumentException
     */
    protected function invalidArguments($code)
    {
        if (!defined('static::INVALID_ARGUMENTS') || empty(static::INVALID_ARGUMENTS[$code])) {
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);
            if (!empty($backtrace[1]['function'])) {
                $message = 'Invalid arguments for method ' . get_class($this) . '::' . $backtrace[1]['function'];
            } else {
                $message = 'Invalid arguments for method';
            }
        } else {
            $message = static::INVALID_ARGUMENTS[$code];
        }
        throw new InvalidArgumentException($message, $code);
    }

}