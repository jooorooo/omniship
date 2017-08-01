<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 22.5.2017 г.
 * Time: 14:15 ч.
 */
namespace Omniship\Common;


use Carbon\Carbon;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

class RequestCourier implements ArrayableInterface, \JsonSerializable, JsonableInterface
{
    use Parameters;

    /**
     * Get Bill ID
     * @return string
     */
    public function getBolId()
    {
        return $this->getParameter('bol_id');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setBolId($value)
    {
        return $this->setParameter('bol_id', $value);
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->getParameter('request_id');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setRequestId($value)
    {
        return $this->setParameter('request_id', $value);
    }

    /**
     * @return Carbon|null
     */
    public function getPickupDate()
    {
        return $this->getParameter('pickup_date');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setPickupDate(Carbon $value = null)
    {
        return $this->setParameter('pickup_date', $value);
    }

    /**
     * @return string|null
     */
    public function getError()
    {
        return $this->getParameter('error');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setError($value)
    {
        return $this->setParameter('error', $value);
    }

    /**
     * @return string|null
     */
    public function getErrorCode()
    {
        return $this->getParameter('error_code');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setErrorCode($value)
    {
        return $this->setParameter('error_code', $value);
    }

}