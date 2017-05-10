<?php
/**
 * Shipping Method Bag
 */
namespace Omniship\Common;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\JsonableInterface;
use Omniship\Interfaces\ShippingMethodInterface;

/**
 * Shipping Item Bag
 *
 * This class defines a bag (multi element set or array) of single shipping items
 * in the Omniship system.
 *
 * @see Item
 */
class QuoteBag implements
    \IteratorAggregate,
    \Countable,
    ArrayableInterface,
    \JsonSerializable,
    JsonableInterface
{
    /**
     * Item storage
     *
     * @see Item
     *
     * @var array
     */
    protected $items;

    /**
     * Constructor
     *
     * @param array $items An array of items
     */
    public function __construct(array $items = array())
    {
        $this->replace($items);
    }

    /**
     * Return all the items
     *
     * @see Item
     *
     * @return array An array of items
     */
    public function all()
    {
        return $this->items;
    }

    /**
     * Replace the contents of this bag with the specified items
     *
     * @see Item
     *
     * @param array $items An array of items
     */
    public function replace(array $items = array())
    {
        $this->items = array();
        foreach ($items as $item) {
            $this->add($item);
        }
    }

    /**
     * Add an item to the bag
     *
     * @see Item
     *
     * @param ShippingMethodInterface|array $item An existing item, or associative array of item parameters
     */
    public function add($item)
    {
        if ($item instanceof ShippingMethodInterface) {
            $this->items[] = $item;
        } else {
            $this->items[] = new Quote($item);
        }
    }

    /**
     * Returns an iterator for items
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->items);
    }

    /**
     * Returns the number of items
     *
     * @return int The number of items
     */
    public function count()
    {
        return count($this->items);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->items as $key => $value) {
            if ($value instanceof ArrayableInterface) {
                $array[$key] = $value->toArray();
            } else {
                $array[$key] = $value;
            }
        }
        return $array;
    }

    /**
     * @return array
     */
    public function jsonSerialize()
    {
        return $this->toArray();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
