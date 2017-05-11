<?php
/**
 * Shipping address
 */

namespace Omniship\Interfaces;

interface StateInterface extends ComponentInterface
{
    /**
     * Get iso2 code
     * @return string
     */
    public function getIso2();
}
