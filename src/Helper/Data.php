<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 30.5.2017 г.
 * Time: 14:44 ч.
 */

namespace Omniship\Helper;

class Data
{
    /**
     * @var Collection
     */
    protected static $countries;

    /**
     * @return Collection
     */
    public static function countries() {
        if(is_null(static::$countries)) {
            static::$countries = Collection::make(include __DIR__ . './../data/countries.php')->keyBy('CountryCode');
        }
        return static::$countries;
    }

}