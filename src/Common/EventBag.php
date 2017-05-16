<?php
/**
 * Shipping Event Bag
 */
namespace Omniship\Common;

use Omniship\Interfaces\ArrayableInterface;
use Omniship\Interfaces\ComponentInterface;
use Omniship\Interfaces\JsonableInterface;

/**
 * Shipping Event Bag
 *
 * This class defines a bag (multi element set or array) of single shipping events
 * in the Omniship system.
 *
 * @see Event
 */
class EventBag implements \IteratorAggregate, \Countable, ArrayableInterface, \JsonSerializable, JsonableInterface
{
    /**
     * Event storage
     *
     * @see Event
     *
     * @var array
     */
    protected $events;

    /**
     * Constructor
     *
     * @param array $events An array of events
     */
    public function __construct(array $events = array())
    {
        $this->replace($events);
    }

    /**
     * Return all the events
     *
     * @see Event
     *
     * @return Component[]
     */
    public function all()
    {
        return $this->events;
    }

    /**
     * Replace the contents of this bag with the specified events
     *
     * @see Event
     *
     * @param array $events An array of events
     */
    public function replace(array $events = array())
    {
        $this->events = array();
        foreach ($events as $event) {
            $this->add($event);
        }
    }

    /**
     * Add an event to the bag
     *
     * @see Event
     *
     * @param ComponentInterface|array $event An existing event, or associative array of event parameters
     */
    public function add($event)
    {
        if ($event instanceof ComponentInterface) {
            $this->events[] = $event;
        } else {
            $this->events[] = new Component($event);
        }
    }

    /**
     * Returns an iterator for events
     *
     * @return \ArrayIterator An \ArrayIterator instance
     */
    public function getIterator()
    {
        return new \ArrayIterator($this->events);
    }

    /**
     * Returns the number of events
     *
     * @return int The number of events
     */
    public function count()
    {
        return count($this->events);
    }

    /**
     * @return array
     */
    public function toArray()
    {
        $array = [];
        foreach ($this->events as $key => $value) {
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
     * @param  int  $options
     * @return string
     */
    public function toJson($options = 0)
    {
        return json_encode($this->jsonSerialize(), $options);
    }
}
