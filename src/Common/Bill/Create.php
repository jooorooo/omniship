<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 22.5.2017 г.
 * Time: 14:15 ч.
 */
namespace Omniship\Common\Bill;


use Carbon\Carbon;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\CreateBillOfLadingInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Parameters;

class Create implements CreateBillOfLadingInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{
    use Parameters;

    const PDF = 'pdf';
    const JPG = 'jpg';
    const JPEG = 'jpg';
    const PNG = 'png';

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
     * {@inheritdoc}
     */
    public function getEstimatedDeliveryDate()
    {
        return $this->getParameter('estimated_delivery_date');
    }

    /**
     * @param  Carbon|null $value
     * @return $this
     */
    public function setEstimatedDeliveryDate(Carbon $value = null)
    {
        return $this->setParameter('estimated_delivery_date', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getBillOfLadingType()
    {
        return $this->getParameter('bill_of_lading_type');
    }

    /**
     * @param  string $value
     * @return $this
     */
    public function setBillOfLadingType($value = self::PDF)
    {
        return $this->setParameter('bill_of_lading_type', $value);
    }

    /**
     * {@inheritdoc}
     */
    public function getBillOfLadingSource()
    {
        return $this->getParameter('bill_of_lading_source');
    }

    /**
     * @param  string (base64) $value
     * @return $this
     */
    public function setBillOfLadingSource($value)
    {
        return $this->setParameter('bill_of_lading_source', $value);
    }

    /**
     * {@inheritdoc}
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
     * {@inheritDoc}
     */
    public function getTotal()
    {
        return $this->getParameter('total');
    }

    /**
     * Set the total price
     * @param mixed $value
     * @return $this
     */
    public function setTotal($value = null)
    {
        return $this->setParameter('total', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getInsurance()
    {
        return $this->getParameter('insurance');
    }

    /**
     * Set Insurance
     * @param mixed $value
     * @return $this
     */
    public function setInsurance($value = null)
    {
        return $this->setParameter('insurance', $value);
    }

}