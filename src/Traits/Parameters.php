<?php

namespace Omniship\Traits;

use Omniship\Helper\Helper;
use Omniship\Interfaces\ArrayableInterface;
use Symfony\Component\HttpFoundation\ParameterBag;

trait Parameters
{
    /**
     * @var \Symfony\Component\HttpFoundation\ParameterBag
     */
    protected $parameters;

    /**
     * Create a new item with the specified parameters
     *
     * @param array|object|null $parameters An array of parameters to set on the new object
     */
    public function __construct($parameters = [])
    {
        $this->initializeFromValues($parameters);
    }

    /**
     * Initialize this item with the specified parameters
     *
     * @param array|null $parameters An array of parameters to set on this object
     * @return $this Item
     */
    public function initialize(array $parameters = null)
    {
        $this->parameters = new ParameterBag();
        if(is_array($parameters)) {
            Helper::initialize($this, $parameters);
        }
        return $this;
    }

    /**
     * @param array|null $parameters An array of parameters to set on this object
     * @return $this
     */
    public function fillFromArray(array $parameters)
    {
        if(is_array($parameters)) {
            Helper::initialize($this, $parameters);
        }
        return $this;
    }

    /**
     * Initialize this item with the specified parameters from $values
     *
     * @param array|object|null $parameters An array of parameters to set on this object
     * @return $this Item
     */
    public function initializeFromValues($parameters)
    {
        if($parameters instanceof ArrayableInterface) {
            $parameters = $parameters->toArray();
        }
        if(is_array($parameters)) {
            return $this->initialize($parameters);
        }

        $values = $this->_getValues();
        $temporary = [];
        foreach($values AS $key => $value) {
            if(is_string($value)) {
                $type = 'string';
                $sub_object = null;
                $setter = $key = $value;
            } else {
                $type = !empty($value['type']) ? $value['type'] : null;
                $sub_object = !empty($value['sub_object']) ? $value['sub_object'] : null;
                $setter = !empty($value['key']) ? $value['key'] : $key;
            }
            $val = null;
            if(is_object($parameters) && isset($parameters->{$key})) {
                $val = $parameters->{$key};
            }
            $temporary[$setter] = $this->setValueType($val, $type, $sub_object);
        }
        return $this->initialize($temporary);
    }

    /**
     * @return array
     */
    protected function _getValues()
    {
        if(property_exists($this, 'values') && is_array($this->values)) {
            return $this->values;
        }

        return [];
    }

    /**
     * @return array
     */
    public function getParameters()
    {
        return $this->parameters->all();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function getParameter($key)
    {
        return $this->parameters->get($key);
    }

    /**
     * @param $key
     * @return mixed
     */
    public function hasParameter($key)
    {
        return $this->parameters->has($key);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function setParameter($key, $value)
    {
        $this->parameters->set($key, $value);
        return $this;
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function forgetParameter($key)
    {
        if($this->parameters->has($key)) {
            $this->parameters->remove($key);
        }
        return $this;
    }

    /**
     * Check object is empty
     * @return bool
     */
    public function isEmpty()
    {
        return $this->parameters->count() < 1;
    }

    /**
     * @return array
     */
    public function toArray()
    {
//        $re = new \ReflectionClass($this);
//        $methods = array_map(function(\ReflectionMethod $method) {
//            if(substr($methodName = $method->getName(), 0, 3) != 'get') {
//                return null;
//            } elseif(in_array($methodName, ['getParameters', 'getParameter'])) {
//                return null;
//            }
//            $key = Helper::snake(substr($methodName, 3));
//            return [
//                'key' => $key,
//                'value' => $this->$methodName()
//            ];
//        }, $re->getMethods(\ReflectionMethod::IS_PUBLIC));
//
//        $methods = array_values(array_filter($methods));
//        $methods = array_combine(array_column($methods, 'key'), array_column($methods, 'value'));
//
//        return $this->_toArray($methods);

        return $this->_toArray($this->parameters->all());
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

    /**
     * @return string
     */
    public function __toString() {
        return $this->toJson();
    }

    /**
     * @param $key
     * @return mixed
     */
    public function __get($key) {
        return $this->getParameter($key);
    }

    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function __set($key, $value) {
        $method = 'set' . Helper::camelCase(ucfirst($key));
        if(method_exists($this, $method)) {
            $this->setParameter($key, $value);
        }
        return $this;
    }

    /**
     * @param $key
     * @return bool
     */
    public function __isset($key) {
        return $this->parameters->has($key);
    }

    /**
     * @param $val
     * @param string $type
     * @param null $sub_object
     * @return array|bool|float|int|object|string
     */
    protected function setValueType($val, $type = 'string', $sub_object = null) {
        switch($type) {
            case 'string':
                $val = (string)$val;
                break;
            case 'int':
            case 'integer':
                $val = (int)$val;
                break;
            case 'float':
            case 'double':
                $val = (float)$val;
                break;
            case 'bool':
            case 'boolean':
                $val = empty(trim((string)$val)) ? false : true;
                break;
            case 'array':
                $val = (array)$val;
                break;
            case 'object':
                $val = (object)$val;
                break;
        }
        return $sub_object ? new $sub_object($val) : $val;
    }

    /**
     * @param array $parameters
     * @return array
     */
    protected function _toArray(array $parameters = [])
    {
        $array = [];
        foreach ($parameters as $key => $value) {
            if ($value instanceof ArrayableInterface) {
                $array[$key] = $this->_toArray($value->toArray());
            } elseif ($value instanceof ParameterBag) {
                $array[$key] = $this->_toArray($value->all());
            } else {
                $array[$key] = is_array($value) ? $this->_toArray($value) : $value;
            }
        }
        return $array;
    }
}
