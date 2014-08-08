<?php

namespace Ephrin\Structures;

/**
 * Class ArrayStructure
 * @package Ephrin\Glutton\MongoDB\Detector
 */
class ArrayStructure
{
    /**
     * @param array|\ArrayAccess|\Countable $value
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isSequential($value){
        if(is_array($value) || ($value instanceof \Countable && $value instanceof \ArrayAccess)){
            for ($i = count($value) - 1; $i >= 0; $i--) {
                if (!isset($value[$i]) && !array_key_exists($i, $value)) {
                    return false;
                }
            }
            return true;
        } else {
            throw new \InvalidArgumentException(
                sprintf('Data type "%s" is not supported by method %s', gettype($value), __METHOD__)
            );
        }
    }

    /**
     * Reverse to \Ephrin\Structures\ArrayStructure::isSequential
     * @param $value
     * @return bool
     */
    public static function isHash($value)
    {
        return !self::isSequential($value);
    }

    /**
     * Another one 
     * @param $value
     * @return bool
     */
    public static function isAssoc($value)
    {
        return array_keys($value) !== range(0, count($value) - 1);
    }
} 
