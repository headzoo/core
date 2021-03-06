<?php
namespace Headzoo\Core;

/**
 * Contains static methods for making comparisons between values.
 *
 * Primarily used when a callback is needed which makes comparisons between
 * two values.
 *
 * #### Example
 *
 * ```php
 * $arr = [
 *      "joe",
 *      "headzoo",
 *      "amy"
 * ];
 * usort($arr, 'Headzoo\Core\Comparator::compare');
 * print_r($arr);
 *
 * // Outputs:
 * // [
 * //   "amy",
 * //   "joe",
 * //   "headzoo"
 * // ]
 * ```
 */
class Comparator
    extends Obj
{
    /**
     * Returns the order of the left and right hand values as an integer
     *
     * Compares its two arguments for order. Returns a negative integer, zero, or a positive integer as
     * the first argument is less than, equal to, or greater than the second.
     *
     * Example:
     * ```php
     * $arr = [
     *      "joe",
     *      "headzoo",
     *      "amy"
     * ];
     * usort($arr, 'Headzoo\Core\Comparator::compare');
     * print_r($arr);
     *
     * // Outputs:
     * // [
     * //   "amy",
     * //   "joe",
     * //   "headzoo"
     * // ]
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return int
     */
    public static function compare($left, $right)
    {
        if ($left < $right) {
            $result = -1;
        } else if ($left > $right) {
            $result = 1;
        } else {
            $result = 0;
        }
        
        return $result;
    }

    /**
     * Returns the reverse order of the left and right hand values as an integer
     *
     * Compares its two arguments for order. Returns a negative integer, zero, or a positive integer as
     * the first argument is greater than, equal to, or less than the second.
     *
     * Example:
     * ```php
     * $arr = [
     *      "joe",
     *      "headzoo",
     *      "amy"
     * ];
     * usort($arr, 'Headzoo\Core\Comparator::reverse');
     * print_r($arr);
     *
     * // Outputs:
     * // [
     * //   "headzoo",
     * //   "joe",
     * //   "amy"
     * // ]
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return int
     */
    public static function reverse($left, $right)
    {
        if ($left < $right) {
            $result = 1;
        } else if ($left > $right) {
            $result = -1;
        } else {
            $result = 0;
        }

        return $result;
    }

    /**
     * Returns whether two values are equal
     *
     * Example:
     * ```php
     * var_dump(Comparator::isEquals(5, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isEquals(5, "5"));
     * // Outputs: bool(true)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isEquals($left, $right)
    {
        return $left == $right;
    }

    /**
     * Returns whether two values are not equal
     *
     * Example:
     * ```php
     * var_dump(Comparator::isNotEquals(5, 5));
     * // Outputs: bool(false)
     *
     * var_dump(Comparator::isNotEquals(5, "5"));
     * // Outputs: bool(false)
     *
     * var_dump(Comparator::isNotEquals(15, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isNotEquals(15, "5"));
     * // Outputs: bool(true)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isNotEquals($left, $right)
    {
        return $left != $right;
    }

    /**
     * Returns whether two values are equal using strict comparison
     *
     * Example:
     * ```php
     * var_dump(Comparator::isStrictlyEquals(5, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isStrictlyEquals(5, "5"));
     * // Outputs: bool(false)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isStrictlyEquals($left, $right)
    {
        return $left === $right;
    }

    /**
     * Returns whether two values are not equal using strict comparison
     *
     * Example:
     * ```php
     * var_dump(Comparator::isStrictlyNotEquals(6, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isStrictlyNotEquals(6, "5"));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isStrictlyNotEquals(5, 5));
     * // Outputs: bool(false)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isStrictlyNotEquals($left, $right)
    {
        return $left !== $right;
    }

    /**
     * Returns whether the left hand value is less than the right hand value
     *
     * Example:
     * ```php
     * var_dump(Comparator::isLessThan(4, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isLessThan(4, "5"));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isLessThan(5, 5));
     * // Outputs: bool(false)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isLessThan($left, $right)
    {
        return $left < $right;
    }

    /**
     * Returns whether the left hand value is less than or equal to the right hand value
     *
     * Example:
     * ```php
     * var_dump(Comparator::isLessThanOrEquals(4, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isLessThanOrEquals(4, "5"));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isLessThanOrEquals(5, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isLessThanOrEquals(6, 5));
     * // Outputs: bool(false)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isLessThanOrEquals($left, $right)
    {
        return $left <= $right;
    }

    /**
     * Returns whether the left hand value is greater than the right hand value
     *
     * Example:
     * ```php
     * var_dump(Comparator::isGreaterThan(6, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isGreaterThan(6, "5"));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isGreaterThan(4, 5));
     * // Outputs: bool(false)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isGreaterThan($left, $right)
    {
        return $left > $right;
    }

    /**
     * Returns whether the left hand value is greater than or equal to the right hand value
     *
     * Example:
     * ```php
     * var_dump(Comparator::isGreaterThanOrEquals(6, 5));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isGreaterThanOrEquals(5, "5"));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isGreaterThanOrEquals(4, 5));
     * // Outputs: bool(false)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isGreaterThanOrEquals($left, $right)
    {
        return $left >= $right;
    }

    /**
     * Returns whether the left hand value is an instance of the right hand value
     *
     * Example:
     * ```php
     * $obj = new stdClass();
     * var_dump(Comparator::isInstanceOf($obj, stdClass::class));
     * // Outputs: bool(true)
     *
     * var_dump(Comparator::isInstanceOf($obj, Comparator::class));
     * // Outputs: bool(false)
     * ```
     *
     * @param  mixed $left  The left value
     * @param  mixed $right The right value
     *
     * @return bool
     */
    public static function isInstanceOf($left, $right)
    {
        return $left instanceof $right;
    }
} 