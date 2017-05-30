<?php
/**
 * Shipping Event Bag
 */
namespace Omniship\Common;

use Omniship\Helper\Collection;

/**
 * Shipping Event Bag
 *
 * This class defines a bag (multi element set or array) of single shipping events
 * in the Omniship system.
 *
 * @see Event
 */
class EventBag  extends Collection
{

    /**
     * Create a new collection.
     *
     * @param  mixed  $items
     */
    public function __construct($items = [])
    {
        $items = array_map(function($item) {
            return !($item instanceof Component) ? new Component($item) : $item;
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
        if(!($value instanceof Component)) {
            $value = new Component($value);
        }
        parent::offsetSet($key, $value);
    }

    /**
     * Get all of the items in the collection.
     *
     * @return Component[]
     */
    public function all()
    {
        return parent::all();
    }
}
