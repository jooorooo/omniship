<?php
/**
 * Shipping address
 */

namespace Omniship\Common;

use Omniship\Address\City;
use Omniship\Address\Country;
use Omniship\Address\Quarter;
use Omniship\Address\State;
use Omniship\Address\Street;
use Omniship\Exceptions\InvalidArgumentException;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Exceptions;
use Omniship\Traits\Parameters;
use Omniship\Interfaces\AddressInterface;
use DateTimeZone;

class Address implements AddressInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{

    use Parameters, Exceptions;

    const INVALID_ARGUMENTS = [
        '10001' => 'Invalid arguments for method Omniship\Common\Address::setCountry',
        '10002' => 'Invalid arguments for method Omniship\Common\Address::setState',
        '10003' => 'Invalid arguments for method Omniship\Common\Address::setCity',
        '10004' => 'Invalid arguments for method Omniship\Common\Address::setTimeZone',
        '10005' => 'Invalid arguments for method Omniship\Common\Address::setQuarter',
    ];

    /**
     * @var array
     */
    protected $time_zones;

    /**
     * Get the address id
     * @return mixed
     */
    public function getId()
    {
        return $this->getParameter('id');
    }

    /**
     * Set address id
     */
    public function setId($value)
    {
        return $this->setParameter('id', $value);
    }

    /**
     * Get the address country
     * @return Country
     */
    public function getCountry()
    {
        return $this->getParameter('country');
    }

    /**
     * Set the address country
     * @param Country|array $country
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setCountry($country)
    {
        if (!($country instanceof Country)) {
            $country = new Country($country);
        }
        if ($country->isEmpty()) {
            $this->invalidArguments('10001');
        }
        return $this->setParameter('country', $country);
    }

    /**
     * Get the address state
     * @return State
     */
    public function getState()
    {
        return $this->getParameter('state');
    }

    /**
     * Set the address state
     * @param State|array $state
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setState($state)
    {
        if (!($state instanceof State)) {
            $state = new State($state);
        }
        if ($state->isEmpty()) {
            $this->invalidArguments('10002');
        }
        return $this->setParameter('state', $state);
    }

    /**
     * Get the address city
     * @return City
     */
    public function getCity()
    {
        return $this->getParameter('city');
    }

    /**
     * Set the address city
     * @param City|array $city
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setCity($city)
    {
        if (!($city instanceof City)) {
            $city = new City($city);
        }
        if ($city->isEmpty()) {
            $this->invalidArguments('10003');
        }
        return $this->setParameter('city', $city);
    }

    /**
     * Get the address quarter
     * @return Quarter
     */
    public function getQuarter()
    {
        return $this->getParameter('quarter');
    }

    /**
     * Set the address quarter
     * @param Quarter|array $quarter
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setQuarter($quarter)
    {
        if (!($quarter instanceof Quarter)) {
            $quarter = new Quarter($quarter);
        }
        if ($quarter->isEmpty()) {
            $this->invalidArguments('10005');
        }
        return $this->setParameter('quarter', $quarter);
    }

    /**
     * Get the address street
     * @return Street
     */
    public function getStreet()
    {
        return $this->getParameter('street');
    }

    /**
     * Set the address street
     * @param Street|array $street
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setStreet($street)
    {
        if (!($street instanceof Street)) {
            $street = new Street($street);
        }
        if ($street->isEmpty()) {
            $this->invalidArguments('10006');
        }
        return $this->setParameter('street', $street);
    }

    /**
     * Get the address street num
     * @return string|mixed
     */
    public function getStreetNumber()
    {
        return $this->getParameter('street_number');
    }

    /**
     * Set the address street num
     * @param $street_number
     * @return $this
     */
    public function setStreetNumber($street_number)
    {
        return $this->setParameter('street_number', $street_number);
    }

    /**
     * Get the address post code
     * @return string|mixed
     */
    public function getPostCode()
    {
        return $this->getParameter('post_code');
    }

    /**
     * Set the address post code
     * @param $post_code
     * @return $this
     */
    public function setPostCode($post_code)
    {
        return $this->setParameter('post_code', $post_code);
    }

    /**
     * Get the address line 1
     * @return string|mixed
     */
    public function getAddress1()
    {
        return $this->getParameter('address1');
    }

    /**
     * Set the address line 1
     * @param string $address
     * @return $this
     */
    public function setAddress1($address)
    {
        return $this->setParameter('address1', $address);
    }

    /**
     * Get the address line 2
     * @return string|mixed
     */
    public function getAddress2()
    {
        return $this->getParameter('address2');
    }

    /**
     * Set the address line 2
     * @param string $address
     * @return $this
     */
    public function setAddress2($address)
    {
        return $this->setParameter('address2', $address);
    }

    /**
     * Get the address line 3
     * @return string|mixed
     */
    public function getAddress3()
    {
        return $this->getParameter('address3');
    }

    /**
     * Set the address line 3
     * @param string $address
     * @return $this
     */
    public function setAddress3($address)
    {
        return $this->setParameter('address3', $address);
    }

    /**
     * Get the address phone
     * @return string|mixed
     */
    public function getPhone()
    {
        return $this->getParameter('phone');
    }

    /**
     * Set the address phone
     * @param string $phone
     * @return $this
     */
    public function setPhone($phone)
    {
        return $this->setParameter('phone', $phone);
    }

    /**
     * Get the address building
     * @return string|mixed
     */
    public function getBuilding()
    {
        return $this->getParameter('building');
    }

    /**
     * Set the address building
     * @param string $building
     * @return $this
     */
    public function setBuilding($building)
    {
        return $this->setParameter('building', $building);
    }

    /**
     * Get the address entrance
     * @return string|mixed
     */
    public function getEntrance()
    {
        return $this->getParameter('entrance');
    }

    /**
     * Set the address entrance
     * @param string $entrance
     * @return $this
     */
    public function setEntrance($entrance)
    {
        return $this->setParameter('entrance', $entrance);
    }

    /**
     * Get the address floor
     * @return string|mixed
     */
    public function getFloor()
    {
        return $this->getParameter('floor');
    }

    /**
     * Set the address floor
     * @param string $floor
     * @return $this
     */
    public function setFloor($floor)
    {
        return $this->setParameter('floor', $floor);
    }

    /**
     * Get the address apartment
     * @return string|mixed
     */
    public function getApartment()
    {
        return $this->getParameter('apartment');
    }

    /**
     * Set the address apartment
     * @param string $apartment
     * @return $this
     */
    public function setApartment($apartment)
    {
        return $this->setParameter('apartment', $apartment);
    }

    /**
     * Get the address first name
     * @return string|mixed
     */
    public function getFirstName()
    {
        return $this->getParameter('first_name');
    }

    /**
     * Set the address first name
     * @param string $first_name
     * @return $this
     */
    public function setFirstName($first_name)
    {
        return $this->setParameter('first_name', $first_name);
    }

    /**
     * Get the address last name
     * @return string|mixed
     */
    public function getLastName()
    {
        return $this->getParameter('last_name');
    }

    /**
     * Set the address last name
     * @param string $last_name
     * @return $this
     */
    public function setLastName($last_name)
    {
        return $this->setParameter('last_name', $last_name);
    }

    /**
     * Get the address company name
     * @return string|mixed
     */
    public function getCompanyName()
    {
        return $this->getParameter('company_name');
    }

    /**
     * Set the address company name
     * @param string $company_name
     * @return $this
     */
    public function setCompanyName($company_name)
    {
        return $this->setParameter('company_name', $company_name);
    }

    /**
     * Get the address time zone
     * @return string|null
     */
    public function getTimeZone()
    {
        return $this->getParameter('timezone');
    }

    /**
     * Set the address time zone
     * @param string|null $timezone
     * @return $this
     */
    public function setTimeZone($timezone)
    {
        if(!is_null($timezone) && array_search(strtolower($timezone), $this->getTimeZones()) === false) {
            $this->invalidArguments('10004', sprintf('Invalid timezone set "%s"', $timezone));
        }
        return $this->setParameter('timezone', $timezone);
    }

    /**
     * @return array
     */
    protected function getTimeZones() {
        if(!is_null($this->time_zones)) {
            return $this->time_zones;
        }
        $list_abbreviations = DateTimeZone::listAbbreviations();
        foreach($list_abbreviations AS $list) {
            $this->time_zones = array_merge(is_array($this->time_zones) ? $this->time_zones : [], array_map(function($timezone) { return $timezone['timezone_id']; }, $list));
        }
        return array_map('strtolower', array_filter(array_unique($this->time_zones)));
    }
}
