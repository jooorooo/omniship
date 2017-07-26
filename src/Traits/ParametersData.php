<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 15.5.2017 г.
 * Time: 17:21 ч.
 */

namespace Omniship\Traits;

use Carbon\Carbon;
use Omniship\Common\Address;
use Omniship\Common\ItemBag;
use Omniship\Common\PieceBag;
use Omniship\Consts;
use Omniship\Helper\Collection;
use Omniship\Helper\Data;
use Symfony\Component\HttpFoundation\ParameterBag;

trait ParametersData
{
    /**
     * @return boolean
     */
    public function getTestMode()
    {
        return $this->getParameter('testMode');
    }
    /**
     * @param  boolean $value
     * @return $this
     */
    public function setTestMode($value)
    {
        return $this->setParameter('testMode', $value);
    }
    /**
     * Get the card token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->getParameter('token');
    }
    /**
     * Sets the card token.
     *
     * @param string $value
     * @return string
     */
    public function setToken($value)
    {
        return $this->setParameter('token', $value);
    }
    /**
     * Get the payment currency code.
     *
     * @return string
     */
    public function getCurrency()
    {
        return $this->getParameter('currency');
    }
    /**
     * Sets the payment currency code.
     *
     * @param string $value
     * @return $this
     */
    public function setCurrency($value)
    {
        if ($value !== null) {
            $value = strtoupper($value);
        }
        return $this->setParameter('currency', $value);
    }
    /**
     * Get the request description.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->getParameter('description');
    }
    /**
     * Sets the request description.
     *
     * @param string $value
     * @return string
     */
    public function setDescription($value)
    {
        return $this->setParameter('description', $value);
    }
    /**
     * @return string
     */
    public function getWeight()
    {
        return $this->getParameter('weight');
    }
    /**
     * @param  $value
     * @return $this
     */
    public function setWeight($value)
    {
        return $this->setParameter('weight', $value);
    }
    /**
     * @return string
     */
    public function getWeightUnit()
    {
        $weight_unit = $this->getParameter('weight_unit');
        if(!$weight_unit) {
            $this->setWeightUnit($this->findCountryData('WeightUnit'));
        }
        return $this->getParameter('weight_unit');
    }
    /**
     * @param  $weight_unit
     * @return $this
     */
    public function setWeightUnit($weight_unit)
    {
        return $this->setParameter('weight_unit', $weight_unit);
    }
    /**
     * @return string
     */
    public function getDimensionUnit()
    {
        $dimension_unit = $this->getParameter('dimension_unit');
        if(!$dimension_unit) {
            $this->setDimensionUnit($this->findCountryData('DimensionalUnit'));
        }
        return $this->getParameter('dimension_unit');
    }
    /**
     * @param  $dimension_unit
     * @return $this
     */
    public function setDimensionUnit($dimension_unit)
    {
        return $this->setParameter('dimension_unit', $dimension_unit);
    }
    /**
     * A list of items in this order
     *
     * @return ItemBag A bag containing items in this order
     */
    public function getItems()
    {
        return $this->getParameter('items') ? : new ItemBag([]);
    }
    /**
     * Set the items in this order
     *
     * @param ItemBag|array $items An array of items in this order
     * @return $this
     */
    public function setItems($items)
    {
        if ($items && !$items instanceof ItemBag) {
            $items = new ItemBag(is_array($items) ? $items : []);
        }
        return $this->setParameter('items', $items);
    }
    /**
     * A list of pieces in this order
     *
     * @return PieceBag A bag containing items in this order
     */
    public function getPieces()
    {
        return $this->getParameter('pieces') ? : new PieceBag([]);
    }
    /**
     * Set the pieces in this order
     *
     * @param PieceBag|array $pieces An array of items in this order
     * @return $this
     */
    public function setPieces($pieces)
    {
        if ($pieces && !$pieces instanceof PieceBag) {
            $pieces = new PieceBag(is_array($pieces) ? $pieces : []);
        }
        return $this->setParameter('pieces', $pieces);
    }
    /**
     * @return string
     */
    public function getPackageType()
    {
        return $this->getParameter('package_type');
    }
    /**
     * @param string $package_type
     * @return $this
     */
    public function setPackageType($package_type)
    {
        return $this->setParameter('package_type', $package_type);
    }
    /**
     * @return Carbon
     */
    public function getShipmentDate()
    {
        return $this->getParameter('shipment_date');
    }
    /**
     * @param  $shipment_date
     * @return $this
     */
    public function setShipmentDate(Carbon $shipment_date = null)
    {
        return $this->setParameter('shipment_date', $shipment_date);
    }
    /**
     * get number of packages
     * @return integer
     */
    public function getNumberOfPieces()
    {
        $number_of_pieces = $this->getPieces()->count();
        if($number_of_pieces < 1) {
            $number_of_pieces = 1;
        }
        return $number_of_pieces;
    }
    /**
     * @param float $value
     * @return $this
     */
    public function setCashOnDeliveryAmount($value) {
        return $this->setParameter('cash_on_delivery_amount', $value);
    }

    /**
     * @return float
     */
    public function getCashOnDeliveryAmount() {
        return $this->getParameter('cash_on_delivery_amount');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setCashOnDeliveryCurrency($value) {
        return $this->setParameter('cash_on_delivery_currency', $value);
    }

    /**
     * @return string
     */
    public function getCashOnDeliveryCurrency() {
        return $this->getParameter('cash_on_delivery_currency') ? : $this->getCurrency();
    }
    /**
     * Get the client note.
     *
     * @return string
     */
    public function getClientNote()
    {
        return $this->getParameter('client_note');
    }
    /**
     * Sets the client note.
     *
     * @param string $value
     * @return $this
     */
    public function setClientNote($value)
    {
        return $this->setParameter('client_note', $value);
    }
    /**
     * @return Address
     */
    public function getReceiverAddress()
    {
        return $this->getParameter('receiver_address');
    }
    /**
     * @param  Address|array $address
     * @return $this
     */
    public function setReceiverAddress($address)
    {
        if(!($address instanceof Address)) {
            $address = new Address($address);
        }
        if ($address->isEmpty()) {
            $this->invalidArguments('20001');
        }
        return $this->setParameter('receiver_address', $address);
    }
    /**
     * @return Address
     */
    public function getSenderAddress()
    {
        return $this->getParameter('sender_address');
    }
    /**
     * @param  Address|array $address
     * @return $this
     */
    public function setSenderAddress($address)
    {
        if(!($address instanceof Address)) {
            $address = new Address($address);
        }
        if ($address->isEmpty()) {
            $this->invalidArguments('20002');
        }
        return $this->setParameter('sender_address', $address);
    }

    /**
     * @return null|string
     */
    public function getSenderTimeZone() {
        return $this->getSenderAddress() ? $this->getSenderAddress()->getTimeZone() : null;
    }

    /**
     * @return null|string
     */
    public function getReceiverTimeZone() {
        return $this->getReceiverAddress() ? $this->getReceiverAddress()->getTimeZone() : null;
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setInsuranceAmount($value) {
        return $this->setParameter('insurance_amount', $value);
    }

    /**
     * @return float
     */
    public function getInsuranceAmount() {
        return $this->getParameter('insurance_amount');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setInsuranceCurrency($value) {
        return $this->setParameter('insurance_currency', $value);
    }

    /**
     * @return string
     */
    public function getInsuranceCurrency() {
        return $this->getParameter('insurance_currency') ? : $this->getCurrency();
    }

    /**
     * @param float $value
     * @return $this
     */
    public function setDeclaredAmount($value) {
        return $this->setParameter('declared_amount', $value);
    }

    /**
     * @return float
     */
    public function getDeclaredAmount() {
        return $this->getParameter('declared_amount');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setDeclaredCurrency($value) {
        return $this->setParameter('declared_currency', $value);
    }

    /**
     * @return string
     */
    public function getDeclaredCurrency() {
        return $this->getParameter('declared_currency') ? : $this->getCurrency();
    }
    /**
     * Get the request TransactionId.
     *
     * @return string
     */
    public function getTransactionId()
    {
        return $this->getParameter('transaction_id');
    }
    /**
     * Sets the request TransactionId.
     *
     * @param string $value
     * @return $this
     */
    public function setTransactionId($value)
    {
        return $this->setParameter('transaction_id', $value);
    }
    /**
     * Get the request BolId.
     *
     * @return string|array|null
     */
    public function getBolId()
    {
        return $this->getParameter('bol_id');
    }
    /**
     * Sets the request BolId.
     *
     * @param string|array $value
     * @return $this
     */
    public function setBolId($value)
    {
        return $this->setParameter('bol_id', $value);
    }
    /**
     * Get the request date.
     *
     * @return null|Carbon
     */
    public function getStartDate()
    {
        return $this->getParameter('start_date');
    }
    /**
     * Sets the request date.
     *
     * @param Carbon $value
     * @return $this
     */
    public function setStartDate(Carbon $value = null)
    {
        return $this->setParameter('start_date', $value);
    }
    /**
     * Get the request date.
     *
     * @return null|Carbon
     */
    public function getEndDate()
    {
        return $this->getParameter('end_date');
    }
    /**
     * Sets the request date.
     *
     * @param Carbon $value
     * @return $this
     */
    public function setEndDate(Carbon $value = null)
    {
        return $this->setParameter('end_date', $value);
    }
    /**
     * Get the request CancelComment.
     *
     * @return string
     */
    public function getCancelComment()
    {
        return $this->getParameter('cancel_comment');
    }
    /**
     * Sets the request CancelComment.
     *
     * @param string $value
     * @return $this
     */
    public function setCancelComment($value)
    {
        return $this->setParameter('cancel_comment', $value);
    }
    /**
     * Get the request address type.
     *
     * @return Address
     */
    public function getAddress()
    {
        return $this->getParameter('address');
    }
    /**
     * Sets the request address.
     *
     * @param Address|array $value
     * @return $this
     */
    public function setAddress($value)
    {
        $value = !($value instanceof Address) ? new Address(is_array($value) ? $value : []) : $value;
        return $this->setParameter('address', $value);
    }
    /**
     * Get the request service id.
     *
     * @return string
     */
    public function getServiceId()
    {
        return $this->getParameter('service_id');
    }
    /**
     * Sets the request Service ID.
     *
     * @param string $value
     * @return $this
     */
    public function setServiceId($value)
    {
        return $this->setParameter('service_id', $value);
    }
    /**
     * @return string
     */
    public function getLanguageCode()
    {
        return $this->getParameter('language_code') ? : 'en';
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setLanguageCode($value)
    {
        return $this->setParameter('language_code', $value);
    }
    /**
     * @return string
     */
    public function getPayer()
    {
        if(!$this->getParameter('payer')) {
            $this->setParameter('payer', Consts::PAYER_SENDER);
        }
        return $this->getParameter('payer');
    }
    /**
     * @param  $payer
     * @return $this
     */
    public function setPayer($payer)
    {
        return $this->setParameter('payer', $payer);
    }
    /**
     * @return string
     */
    public function getLogo()
    {
        return $this->getParameter('logo');
    }
    /**
     * @param  $logo
     * @return $this
     */
    public function setLogo($logo)
    {
        return $this->setParameter('logo', $logo);
    }
    /**
     * @return string
     */
    public function getContent()
    {
        return $this->getParameter('content');
    }
    /**
     * @param string $content
     * @return $this
     */
    public function setContent($content)
    {
        return $this->setParameter('content', $content);
    }
    /**
     * @return bool
     */
    public function getIsDocuments()
    {
        return $this->getParameter('is_documents');
    }
    /**
     * @param bool $value
     * @return $this
     */
    public function setIsDocuments($value)
    {
        return $this->setParameter('is_documents', (bool)$value);
    }
    /**
     * Get options (open,test)
     * @return string
     */
    public function getOptionBeforePayment()
    {
        return $this->getParameter('option_before_payment');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setOptionBeforePayment($value)
    {
        return $this->setParameter('option_before_payment', $value);
    }
    /**
     * @return bool
     */
    public function getBackReceipt()
    {
        return (bool)$this->getParameter('back_receipt');
    }
    /**
     * @param bool $value
     * @return $this
     */
    public function setBackReceipt($value)
    {
        return $this->setParameter('back_receipt', (bool)$value);
    }
    /**
     * @return bool
     */
    public function getBackDocuments()
    {
        return (bool)$this->getParameter('back_documents');
    }
    /**
     * @param bool $value
     * @return $this
     */
    public function setBackDocuments($value)
    {
        return $this->setParameter('back_documents', (bool)$value);
    }
    /**
     * @return string
     */
    public function getReceiverEmail()
    {
        return $this->getParameter('receiver_email');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setReceiverEmail($value)
    {
        return $this->setParameter('receiver_email', $value);
    }
    /**
     * @return string
     */
    public function getSenderEmail()
    {
        return $this->getParameter('sender_email');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setSenderEmail($value)
    {
        return $this->setParameter('sender_email', $value);
    }
    /**
     * @return string
     */
    public function getReceiverPhone()
    {
        $address = $this->getReceiverAddress();
        return $address ? $address->getPhone() : null;
    }
    /**
     * @return string
     */
    public function getSenderPhone()
    {
        $address = $this->getSenderAddress();
        return $address ? $address->getPhone() : null;
    }
    /**
     * @return string
     */
    public function getPaymentMethod()
    {
        return $this->getParameter('payment_method');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setPaymentMethod($value)
    {
        return $this->setParameter('payment_method', $value);
    }
    /**
     * @return string
     */
    public function getInstructionReturns()
    {
        return $this->getParameter('instruction_returns');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setInstructionReturns($value)
    {
        return $this->setParameter('instruction_returns', $value);
    }
    /**
     * @return string
     */
    public function getCodAccount()
    {
        return $this->getParameter('cod_account');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setCodAccount($value)
    {
        return $this->setParameter('cod_account', $value);
    }
    /**
     * @return string
     */
    public function getPackageId()
    {
        return $this->getParameter('package_id');
    }
    /**
     * @param string $value
     * @return $this
     */
    public function setPackageId($value)
    {
        return $this->setParameter('package_id', $value);
    }
    /**
     * @param $key
     * @return mixed|ParameterBag
     */
    public function getOtherParameters($key = null)
    {
        if(is_null($this->getParameter('other_parameters'))) {
            $this->setParameter('other_parameters', new ParameterBag());
        }
        /** @var $other ParameterBag */
        $other = $this->getParameter('other_parameters');
        return $key ? $other->get($key) : $other;
    }
    /**
     * @param  $key
     * @param  $value
     * @return $this
     */
    public function setOtherParameters($key, $value = null)
    {
        if(is_array($key) || $key instanceof ParameterBag) {
            foreach($key as $k => $v) {
                $this->getOtherParameters()->set($k, $v);
            }
        } else {
            $this->getOtherParameters()->set($key, $value);
        }
        return $this;
    }

    /**
     * @param string $type (WeightUnit|DimensionalUnit)
     * @return string|null
     */
    public function findCountryData($type) {
        if(is_null($address = $this->getSenderAddress())) {
            $address = $this->getAddress();
        }
        if(!$address || is_null($country = $address->getCountry())) {
            return null;
        }
        $country = Collection::make(Data::countries()->get(strtoupper($country->getIso2())));
        if(!$country->count()) {
            return null;
        }
        return $country->get($type);
    }

}