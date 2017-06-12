<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 12.6.2017 г.
 * Time: 16:48 ч.
 */

namespace Omniship\Common;

use Carbon\Carbon;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\CodPaymentInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

class CodPayment implements CodPaymentInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{
    use Parameters;

    /**
     * Get item id
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set item id
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * @return Carbon|null
     */
    public function getDate()
    {
        return $this->getParameter('date');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setDate(Carbon $value = null)
    {
        return $this->setParameter('date', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getPrice()
    {
        return $this->getParameter('price');
    }

    /**
     * Set the item price
     */
    public function setPrice($value)
    {
        return $this->setParameter('price', $value);
    }

}