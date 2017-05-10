<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 10:51 ч.
 */

namespace Omniship\Interfaces;

interface ShippingMethodInterface extends ComponentInterface
{
    /**
     * Get shipping method code
     * @return string
     */
    public function getCode();
}
