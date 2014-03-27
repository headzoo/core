<?php
namespace Headzoo\Utilities;

/**
 * Contains static methods for working with arrays.
 */
class Arrays
    extends Obj
{
    /**
     * Default conjunction used by the conjunct() method
     */
    const DEFAULT_CONJUNCTION = "and";

    /**
     * The default separator string using by joining methods
     */
    const DEFAULT_SEPARATOR = ", ";
    
    /**
     * Returns true if the $array contains the key $key with the value $value
     *
     * Searches array $array for the key $key, and returns true if the key is found,
     * and the value of the key is $value. Returns false if the key does not exist, or
     * the key value does not equal $value.
     *
     * @param  array  $array The array to scan
     * @param  string $key   The key to find
     * @param  mixed  $value The key value
     * @param  bool   $multi Is $array a multidimensional array?
     * @return bool
     */
    public static function containsKeyValue(array $array, $key, $value, $multi = true)
    {
        if (!$multi) return (array_key_exists($key, $array) && $array[$key] == $value);
        foreach($array as $sub) {
            foreach($sub as $k => $v) {
                if ($k == $key && $v == $value) return true;
            }
        }
        return false;
    }

    /**
     * Returns an array of column values from $array
     *
     * Returns an array of values from a multidimensional array where the
     * key equals $column. Similar to the way databases can return a list of
     * column values from a list of matched rows.
     *
     * Example:
     * ```php
     *  $arr = [
     *      0 => [
     *          "username" => "headzoo",
     *          "email" => "sean@headzoo.io"
     *      ],
     *      1 => [
     *          "username" => "joe",
     *          "email" => "joe@headzoo.io"
     *      ]
     *  ]
     *  
     *  $ret = Arrays::column($arr, "username");
     * ```
     * 
     * Returns:
     *  `["headzoo", "joe"]`
     * 
     * @param  array  $array  The array with values
     * @param  string $column The column name
     * @return array
     */
    public static function column(array $array, $column)
    {
        $columns = array();
        foreach($array as $value) {
            if (isset($value[$column])) {
                $columns[] = $value[$column];
            }
        }
        return $columns;
    }

    /**
     * Filters columns of an array using a callback function
     *
     * Similar to the column() method, this method returns an array of values
     * from a multidimensional array where the key equals $column and the list
     * of column values filtered by a callback function. Each element in $array
     * is passed to the callback function and the callback returns true to keep
     * the element, or false to remove it.
     *
     * The callback function will receive each item in the array as the first
     * argument, and the array index/key as the second argument.
     *
     * Example:
     * ```php
     *  $a = [
     *      0 => [
     *          "username" => "headzoo",
     *          "email"    => "sean@headzoo.io",
     *          "admin"    => true
     *      ],
     *      1 => [
     *          "username" => "joe",
     *          "email"    => "joe@headzoo.io",
     *          "admin"    => false
     *      ],
     *      2 => [
     *          "username" => "sam",
     *          "email"    => "sam@headzoo.io",
     *          "admin"    => true
     *      ]
     *  ];
     *  $ret = Arrays::columnFilter($a, "username", function($element) { return $element["admin"]; });
     * ```
     * 
     * Returns:
     *  `["headzoo", "sam"]`
     *
     * @param  array    $array    Multidimensional array
     * @param  string   $column   Name of the column
     * @param  callable $callback Filtering function
     * @return array
     */
    public static function columnFilter(array $array, $column, $callback)
    {
        foreach($array as $key => $value) {
            if (!$callback($value, $key)) {
                unset($array[$key]);
            }
        }
        return self::column($array, $column);
    }

    /**
     * Joins the elements of an array using an optional callback
     *
     * Works exactly the same as php's join() method, however each element of
     * the array will be passed to the callback function. The callback return
     * value is what gets joined.
     *
     * Example:
     * ```php
     * $array = [
     *      "headzoo",
     *      "joe",
     *      "sam"
     * ];
     *  
     * echo Arrays::join($array);
     * // Outputs: headzoo, joe, sam
     * 
     * echo Arrays::join($array, " - ");
     * // Outputs: headzoo - joe - sam
     * 
     * echo Arrays::join($array, ", ", 'Headzoo\Utilities\Strings::quote');
     * // Outputs: 'headzoo', 'joe', 'sam'
     *
     * // The default separator will be used when the middle argument is omitted, and the
     * // last argument is callable object.
     * echo Arrays::join($array, 'Headzoo\Utilities\Strings::quote');
     * ```
     *
     * @param  array    $array     The array to join
     * @param  string   $separator The separator string
     * @param  callable $callback  Callback applied to each element of the array
     * @return string
     */
    public static function join(array $array, $separator = self::DEFAULT_SEPARATOR, callable $callback = null)
    {
        Functions::swapCallable($separator, $callback, self::DEFAULT_SEPARATOR);
        if (null !== $callback) {
            $array = array_map($callback, $array);
        }
        
        return join($separator, $array);
    }

    /**
     * Joins an array of values with a final conjunction
     * 
     * Similar to the Arrays::join() method, this method combines the array values using the default separator,
     * and joins the final item in the array with a conjunction. An array of strings can be turned into
     * a list of items, for example ["food", "water", "shelter"] becomes "food, water, and shelter".
     * 
     * Examples:
     * ```php
     * $array = [
     *      "headzoo",
     *      "joe",
     *      "sam"
     * ];
     * 
     * echo Arrays::conjunct($array);
     * // Outputs: headzoo, joe, and sam
     * 
     * echo Arrays::conjunct($array, "and", 'Headzoo\Utilities\Strings::quote');
     * // Outputs: 'headzoo', 'joe', and 'sam'
     * 
     * // The default conjunction will be used when the middle argument is omitted, and the
     * // last argument is callable object.
     * echo Arrays::conjunct($array, 'Headzoo\Utilities\Strings::quote');
     * ```
     * 
     * @param  array    $array        The array of values to join
     * @param  string   $conjunction  The conjunction word to use
     * @param  callable $callback     Optional callback applied to each element of the array
     * @return string
     */
    public static function conjunct(array $array, $conjunction = self::DEFAULT_CONJUNCTION, callable $callback = null)
    {
        Functions::swapCallable($conjunction, $callback, self::DEFAULT_CONJUNCTION);
        if (null !== $callback) {
            $array = array_map($callback, $array);
        }
        if (count($array) > 1) {
            $final     = array_pop($array);
            $sentence  = join(self::DEFAULT_SEPARATOR, $array);
            $separator = trim(self::DEFAULT_SEPARATOR);
            $sentence  = "{$sentence}{$separator} {$conjunction} {$final}";
        } else {
            $sentence = array_pop($array);
        }
        
        return $sentence;
    }

    /**
     * Finds the first or last occurrence of a string within an array
     * 
     * Similar to the array_search() function, this method only searches for strings, and
     * does so in a case-insensitive manner. The value of $needle may be any type which is
     * castable to a string. An E_USER_WARNING is triggered if the value can't be cast to a string.
     * 
     * Finds the first occurrence of the needle when $reverse is false. Otherwise the method finds
     * the last occurrence of the needle.
     * 
     * Returns the array index where the string was found, or false if the string was not
     * found.
     * 
     * @param  array $array   The array to search
     * @param  mixed $needle  The string value to find
     * @param  bool  $reverse Return the last occurrence of the needle
     * @return mixed
     */
    public static function findString(array $array, $needle, $reverse = false)
    {
        if (!is_scalar($needle) && null !== $needle) {
            trigger_error(
                "Non-scalar search value; cannot cast to a string.", 
                E_USER_WARNING
            );
        }
        
        if ($reverse) {
            $array = array_reverse($array, true);
        }
        return array_search(
            strtolower((string)$needle),
            array_map("strtolower", $array)
        );
    }
}