<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 12.6.2017 г.
 * Time: 16:48 ч.
 */

namespace Omniship\Common;

use Omniship\Helper\Collection;
use Omniship\Interfaces\CodPaymentInterface;

class CodPaymentBag extends Collection
{

    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     */
    public function __construct($items = [])
    {
        $items = array_map(function($item) {
            return !($item instanceof CodPaymentInterface) ? new CodPayment($item) : $item;
        }, $items);
        parent::__construct($items);
    }

    /**
     * Set the item at a given offset.
     *
     * @param  mixed  $key
     * @param  mixed  $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        if(!($value instanceof CodPaymentInterface)) {
            $value = new CodPayment($value);
        }
        parent::offsetSet($key, $value);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return Item[]
     */
    public function all()
    {
        return parent::all();
    }
}