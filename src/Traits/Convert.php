<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 20.6.2017 г.
 * Time: 16:34 ч.
 */

namespace Omniship\Traits;

use Crisu83\Conversion\Quantity\Length\Length;
use Crisu83\Conversion\Quantity\Mass\Mass;
use Omniship\Exceptions\InvalidArgumentException;

trait Convert
{

    /**
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    public function validateWeightUnit($key)
    {
        if (!defined('static::SUPPORT_WEIGHT') || !static::SUPPORT_WEIGHT) {
            throw new InvalidArgumentException(sprintf('Supported weight is not defined for %s'), __CLASS__);
        }
        $support = is_array(static::SUPPORT_WEIGHT) ? static::SUPPORT_WEIGHT : [static::SUPPORT_WEIGHT];
        if (in_array($key, $support)) {
            return $key;
        }
        return array_shift($support);
    }

    /**
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    public function validateLengthUnit($key)
    {
        if (!defined('static::SUPPORT_LENGTH') || !static::SUPPORT_LENGTH) {
            throw new InvalidArgumentException(sprintf('Supported length is not defined for %s'), __CLASS__);
        }
        $support = is_array(static::SUPPORT_LENGTH) ? static::SUPPORT_LENGTH : [static::SUPPORT_LENGTH];
        if (in_array($key, $support)) {
            return $key;
        }
        return array_shift($support);
    }

    /**
     * @param float $value
     * @param string $unit
     * @return float
     */
    public function convertWeightUnit($value, $unit)
    {
        if ($unit == ($support = $this->validateWeightUnit($unit))) {
            return $value;
        }
        $mass = new Mass($value, $unit);
        return $mass->to($support)->getValue();
    }

    /**
     * @param $value
     * @param $unit
     * @return float
     */
    public function convertLengthUnit($value, $unit)
    {
        if ($unit == ($support = $this->validateLengthUnit($unit))) {
            return $value;
        }
        $mass = new Length($value, $unit);
        return $mass->to($support)->getValue();
    }

}