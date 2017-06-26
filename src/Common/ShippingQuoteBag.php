<?php
/**
 * Shipping Method Bag
 */
namespace Omniship\Common;

use Omniship\Helper\Collection;

/**
 * Shipping Item Bag
 *
 * This class defines a bag (multi element set or array) of single shipping items
 * in the Omniship system.
 *
 * @see Item
 */
class ShippingQuoteBag extends Collection
{

    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     */
    public function __construct($items = [])
    {
        $items = array_map(function($item) {
            return is_array($item) ? new ShippingQuote($item) : $item;
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
        if(is_array($value)) {
            $value = new ShippingQuote($value);
        }
        parent::offsetSet($key, $value);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return ShippingQuote[]
     */
    public function all()
    {
        return parent::all();
    }
}
