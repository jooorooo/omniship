<?php
/**
 * Shipping address
 */

namespace Omniship\Common;

use Omniship\Address\City;
use Omniship\Address\Country;
use Omniship\Address\Office;
use Omniship\Address\Quarter;
use Omniship\Address\State;
use Omniship\Address\Street;
use Omniship\Exceptions\InvalidArgumentException;
use Omniship\Helper\Str;
use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Traits\Exceptions;
use Omniship\Traits\Parameters;
use Omniship\Interfaces\AddressInterface;
use DateTimeZone;
//formatter

use CommerceGuys\Addressing\Model\Address AS AddressFormatter;
use CommerceGuys\Addressing\Formatter\DefaultFormatter;
use CommerceGuys\Addressing\Repository\AddressFormatRepository;
use CommerceGuys\Addressing\Repository\CountryRepository;
use CommerceGuys\Addressing\Repository\SubdivisionRepository;

class Address implements AddressInterface, ArrayableInterface, \JsonSerializable, JsonableInterface
{

    use Parameters, Exceptions;

    const INVALID_ARGUMENTS = [
        '10001' => 'Invalid arguments for method Omniship\Common\Address::setCountry',
        '10002' => 'Invalid arguments for method Omniship\Common\Address::setState',
        '10003' => 'Invalid arguments for method Omniship\Common\Address::setCity',
        '10004' => 'Invalid arguments for method Omniship\Common\Address::setTimeZone',
        '10005' => 'Invalid arguments for method Omniship\Common\Address::setQuarter',
        '10006' => 'Invalid arguments for method Omniship\Common\Address::setStreet',
        '10007' => 'Invalid arguments for method Omniship\Common\Address::setOffice',
    ];

    /**
     * @var array
     */
    protected $time_zones;

    /**
     * @var array
     */
    protected $full_name_template = '{first_name} {last_name}';

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
     * @param $value
     * @return $this
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
        if(!$state) {
            return $this;
        }
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
        if(!$quarter) {
            return $this;
        }
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
        if(!$street) {
            return $this;
        }
        if (!($street instanceof Street)) {
            $street = new Street($street);
        }
        if ($street->isEmpty()) {
            $this->invalidArguments('10006');
        }
        return $this->setParameter('street', $street);
    }

    /**
     * Get the address office
     * @return Office
     */
    public function getOffice()
    {
        return $this->getParameter('office');
    }

    /**
     * Set the address street
     * @param Office|array $office
     * @return $this
     * @throws InvalidArgumentException
     */
    public function setOffice($office)
    {
        if(!$office) {
            return $this;
        }
        if (!($office instanceof Office)) {
            $office = new Office($office);
        }
        if ($office->isEmpty()) {
            $this->invalidArguments('10007');
        }
        return $this->setParameter('office', $office);
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
     * Get the address note
     * @return string|mixed
     */
    public function getNote()
    {
        return $this->getParameter('note');
    }

    /**
     * Set the address note
     * @param string $address
     * @return $this
     */
    public function setNote($address)
    {
        return $this->setParameter('note', $address);
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
     * Get the address provider
     * @return string|mixed
     */
    public function getProvider()
    {
        return $this->getParameter('provider');
    }

    /**
     * Set the address provider
     * @param string $provider
     * @return $this
     */
    public function setProvider($provider)
    {
        return $this->setParameter('provider', $provider);
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
        if(!$timezone) {
            return $this;
        }
        if(array_search(strtolower($timezone), $this->getTimeZones()) === false) {
            $this->invalidArguments('10004', sprintf('Invalid timezone set "%s"', $timezone));
        }
        return $this->setParameter('timezone', $timezone);
    }

    /**
     * Get the full name from template
     * @return string|null
     */
    public function getFullName()
    {
        return str_replace([
            '{first_name}',
            '{last_name}'
        ], [
            $this->getFirstName(),
            $this->getLastName(),
        ], $this->getTemplateFullName());
    }

    /**
     * Get template for full name
     * @return mixed
     */
    public function getTemplateFullName()
    {
        return $this->full_name_template;
    }

    /**
     * Set template for full name
     * @param $value
     * @return $this
     */
    public function setTemplateFullName($value)
    {
        $this->full_name_template = $value;
        return $this;
    }

    public function format($html = true) {
        $addressFormatRepository = new AddressFormatRepository();
        $countryRepository = new CountryRepository();
        $subdivisionRepository = new SubdivisionRepository();
        $formatter = new DefaultFormatter($addressFormatRepository, $countryRepository, $subdivisionRepository, $this->getCountry()->getIso2(), [
            'html' => $html
        ]);
        // Options passed to the constructor or setOption / setOptions allow turning
        // off html rendering, customizing the wrapper element and its attributes.

        $address = new AddressFormatter($this->getCountry()->getIso2());
        //add company or names to address
        if($company = $this->getCompanyName()) {
            $address = $address->withRecipient($company);
        }
        if($recipient = $this->getFullName()) {
            $address = $address->withRecipient($recipient);
        }
        //add state to address
        if($state = $this->getState()) {
            $address = $address->withAdministrativeArea($state->getIso2());
        }
        //add city to address
        if($city = $this->getCity()) {
            $address = $address->withLocality($city->getName());
        }
        //add post code to address
        if($postal_code = $this->getPostCode()) {
            $address = $address->withPostalCode($postal_code);
        }
        //if address is office return formatted address
        if(!is_null($office = $this->getOffice())) {
            $address = $address->withAddressLine1($office->getName());
            return $formatter->format($address);
        }

        $line1 = '';
        if(!is_null($street = $this->getStreet())) {
            $number = $this->getStreetNumber();
            $line1 .= implode(' ', array_filter([$street->getName(), ($number ? '#' . $number : '')]));
        } else if(!is_null($quarter = $this->getQuarter())) {
            $line1 .= $quarter->getName();
        }
        if($other = implode(' - ', array_filter([$this->getBuilding(), $this->getEntrance(), $this->getFloor(), $this->getApartment()]))) {
            $line1 .= ($line1 ? ' / ' : '') . $other;
        }
        if($line1) {
            $address = $address->withAddressLine1($line1);
        }
        if($lines = implode("\n", array_filter([$this->getAddress1(), $this->getAddress2(), $this->getAddress3()]))) {
            $address = $address->withAddressLine2($lines);
        }

        return $formatter->format($address);
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
        return $this->time_zones = array_map('\Omniship\Helper\Helper::lower', array_filter(array_unique($this->time_zones)));
    }

}
