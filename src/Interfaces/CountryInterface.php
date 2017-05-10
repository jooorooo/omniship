<?php
/**
 * Shipping address
 */

namespace Omniship\Interfaces;

interface CountryInterface extends ComponentInterface
{

    /**
     * Get iso2
     */
    public function getIso2();
    /**
     * Get iso3
     */
    public function getIso3();
}
