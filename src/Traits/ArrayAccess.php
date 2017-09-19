<?php
/**
 * Created by PhpStorm.
 * User: joro
 * Date: 29.8.2017 г.
 * Time: 12:38 ч.
 */

namespace Omniship\Traits;


trait ArrayAccess
{

    /**
     * Whether a offset exists
     * @return boolean true on success or false on failure.
     */
    public function offsetExists($offset) {
        return !empty($this->parameters) && $this->parameters->has($offset);
    }

    /**
     * Offset to retrieve
     * @param mixed $offset
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset) {
        if($this->offsetExists($offset)) {
            return $this->parameters->get($offset);
        }
        return null;
    }

    /**
     * Offset to set
     * @param mixed $offset
     * @param mixed $value
     * @return void
     */
    public function offsetSet($offset, $value) {
        if(!empty($this->parameters)) {
            $this->parameters->set($offset, $value);
        }
    }

    /**
     * Offset to unset
     * @param mixed $offset
     * @return void
     */
    public function offsetUnset($offset) {
        if(!empty($this->parameters)) {
            $this->parameters->remove($offset);
        }
    }
}