<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 10.5.2017 г.
 * Time: 18:16 ч.
 */

namespace Omniship\Common;

use Carbon\Carbon;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Interfaces\ServiceInterface;
use Omniship\Traits\Parameters;

/**
 * Shipping Quote
 *
 * This class defines a single quote in the Omniship system.
 *
 * @see ServiceInterface
 */
class Service implements ServiceInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
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
     * @param $value
     * @return $this
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->getParameter('name');
    }

    /**
     * Set the item name
     * @param $value
     * @return $this
     */
    public function setName($value)
    {
        return $this->setParameter('name', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportFixedTime()
    {
        return $this->getParameter('support_fixed_time');
    }

    /**
     * Set Fixed Time support
     * @param $value
     * @return $this
     */
    public function setSupportFixedTime($value)
    {
        return $this->setParameter('support_fixed_time', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportCashOnDelivery()
    {
        return $this->getParameter('support_cash_on_delivery');
    }

    /**
     * Set Cash On Delivery support
     * @param $value
     * @return $this
     */
    public function setSupportCashOnDelivery($value)
    {
        return $this->setParameter('support_cash_on_delivery', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportInsurance()
    {
        return $this->getParameter('support_insurance');
    }

    /**
     * Set Insurance support
     * @param $value
     * @return $this
     */
    public function setSupportInsurance($value)
    {
        return $this->setParameter('support_insurance', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportBackDocuments()
    {
        return $this->getParameter('support_back_documents');
    }

    /**
     * Set Back Documents support
     * @param $value
     * @return $this
     */
    public function setSupportBackDocuments($value)
    {
        return $this->setParameter('support_back_documents', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportBackReceipt()
    {
        return $this->getParameter('support_back_receipt');
    }

    /**
     * Set Back Receipt support
     * @param $value
     * @return $this
     */
    public function setSupportBackReceipt($value)
    {
        return $this->setParameter('support_back_receipt', $value);
    }

    /**
     * {@inheritDoc}
     */
    public function getSupportToBeCalled()
    {
        return $this->getParameter('support_to_be_called');
    }

    /**
     * Set Back Receipt support
     * @param $value
     * @return $this
     */
    public function setSupportToBeCalled($value)
    {
        return $this->setParameter('support_to_be_called', $value);
    }


}