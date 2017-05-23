<?php
/**
 * Shipping address
 */

namespace Omniship\Interfaces;

use Omniship\Address\City;
use Omniship\Address\Country;
use Omniship\Address\Office;
use Omniship\Address\Quarter;
use Omniship\Address\State;

interface AddressInterface
{

    /**
     * Get the address id
     * @return mixed
     */
    public function getId();
    /**
     * Get the address country
     * @return Country
     */
    public function getCountry();
    /**
     * Get the address state
     * @return State
     */
    public function getState();
    /**
     * Get the address city
     * @return City
     */
    public function getCity();
    /**
     * Get the address office
     * @return Office
     */
    public function getOffice();
    /**
     * Get the address quarter
     * @return Quarter
     */
    public function getQuarter();
    /**
     * Get the address street
     * @return string|mixed
     */
    public function getStreet();
    /**
     * Get the address street number
     * @return string|mixed
     */
    public function getStreetNumber();
    /**
     * Get the address post code
     * @return string|mixed
     */
    public function getPostCode();
    /**
     * Get the address line 1
     * @return string|mixed
     */
    public function getAddress1();
    /**
     * Get the address line 2
     * @return string|mixed
     */
    public function getAddress2();
    /**
     * Get the address line 3
     * @return string|mixed
     */
    public function getAddress3();
    /**
     * Get the address note
     * @return string|mixed
     */
    public function getNote();
    /**
     * Get the address phone
     * @return string|mixed
     */
    public function getPhone();
    /**
     * Get the address building
     * @return string|mixed
     */
    public function getBuilding();
    /**
     * Get the address entrance
     * @return string|mixed
     */
    public function getEntrance();
    /**
     * Get the address floor
     * @return string|mixed
     */
    public function getFloor();
    /**
     * Get the address apartment
     * @return string|mixed
     */
    public function getApartment();
    /**
     * Get the address first name
     * @return string|mixed
     */
    public function getFirstName();
    /**
     * Get the address last name
     * @return string|mixed
     */
    public function getLastName();
    /**
     * Get the address company name
     * @return string|mixed
     */
    public function getCompanyName();
}
