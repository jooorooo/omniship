<?php
/**
 * Tracking Bag
 */
namespace Omniship\Common;

use Omniship\Helper\Collection;
use Omniship\Interfaces\TrackingInterface;

/**
 * Shipping Tracking Multiple Bag
 *
 * This class defines a bag (multi element set or array) of single shipping items
 * in the Omniship system.
 *
 * @see Item
 */
class TrackingMultipleBag extends Collection
{

    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     */
    public function __construct($items = [])
    {
        $items = array_map(function($item) {
            return !($item instanceof TrackingBag) ? new TrackingBag($item) : $item;
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
        if(!($value instanceof TrackingBag)) {
            $value = new TrackingBag($value);
        }
        parent::offsetSet($key, $value);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return TrackingBag[]
     */
    public function all()
    {
        return parent::all();
    }
}
