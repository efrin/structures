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
    public static function isSequentialFastest($value)
    {
        if (is_array($value) || ($value instanceof \Countable && $value instanceof \ArrayAccess)) {
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

    public static function isSequentialSimple(array $value)
    {
        return true !== boolval(array_diff_key($value, (new \SplFixedArray(count($value)))->toArray()));
    }

    /**
     * @param array|\ArrayAccess|\Countable $value
     * @return bool
     * @throws \InvalidArgumentException
     */
    public static function isSequentialExotic($value)
    {
        if (is_array($value) || ($value instanceof \Countable && $value instanceof \ArrayAccess)) {
            $count = count($value);

            $half = (int)floor($count / 2);

            for ($m = 0; $m < $half; $m++) {
                if (isset($value[$m]) && isset($value[$half + $m])) {
                    continue;
                } elseif (!array_key_exists($m, $value) || !array_key_exists($half + $m, $value)) {
                    return false;
                }
            }

            return !boolval($count % 2 && !isset($value[$count - 1]) && !array_key_exists($count - 1, $value));

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
        return !self::isSequentialFastest($value);
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